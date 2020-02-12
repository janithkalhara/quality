<?php 
defined("HEXEC") or die("Restrited Access.");
require_once 'includes/HDatabase.php';
require_once 'modules/mod_smallFruitInsertion/ajax/updateHandler.php';
require_once 'libraries/base/project/lib_project.php'; 
require_once 'libraries/base/grade/lib_grade.php';
$edit = (isset($_GET['action']) && $_GET['action'] == 'edit') ? true : false;

$tableHeaders = array('Declared Quantity'=>array('w'=>98),
						'Actual Quantity'=>array('w'=>85),
						'11.0-14.5'=>array('w'=>66),
						'14.5-17.0'=>array('w'=>64),
						'17.0-29.0'=>array('w'=>67),
						'29.0-44.0'=>array('w'=>60),
						'CRS'=>array('w'=>66),
						'Reject'=>array('w'=>66),
						'Hidden Loss'=>array('w'=>80),
						'Weight Loss'=>array('w'=>84)
					);

$projects = Project::getProjectsv2(true,false);
if($edit){
	$urlData = json_decode(urldecode($_GET['id']));
	$project = $urlData[0];
	$vehicle = $urlData[1];
	$date = $urlData[2];	
	$handler = new UpdateHandler($project, $vehicle, $date);
	$reference = array('p' => $project,'v' => $vehicle,'d' => $date);
	$_SESSION['edit.reference'] = $reference;
	$headers = $handler->getHeaders();
	$gradeSamples = $handler->getSamples();
	$crs = $handler->getCrsSamples();
}

$grades = Grade::getSubGradesByCategory(5);

?>
<script type="text/javascript">
	var edit = <?php echo ($edit)?'true':'false'?>;
	var projectsIn = [];
	var projectsIn = <?php echo json_encode($projects); ?>;
	var metadata = {grades:<?php echo json_encode($grades); ?>}
	var testing_data = [];
</script>
<link rel='stylesheet' type="text/css" href="modules/mod_smallFruitInsertion/css/smallFruitInsertion.css" />
<link rel='stylesheet' type="text/css" href="modules/mod_smallFruitInsertion/css/jquery-ui-timepicker-addon.css" />
<link rel='stylesheet' type="text/css" href="css/select2.css" />
<script type="text/javascript" src="modules/mod_smallFruitInsertion/js/helper.js"></script>
<script type="text/javascript" src="modules/mod_smallFruitInsertion/js/tableAnalyzer.js"></script>
<script type="text/javascript" src="modules/mod_smallFruitInsertion/js/tableSupporter.js"></script>
<script type="text/javascript" src="modules/mod_smallFruitInsertion/js/tableWizard.js"></script>
<script type="text/javascript" src="modules/mod_smallFruitInsertion/js/smallFruitInsertionBalanceSheet.js" ></script>
<script type="text/javascript" src="modules/mod_smallFruitInsertion/js/tablePrinter.js"></script>
<script type="text/javascript" src="modules/mod_insertionData/js/plupload.full.js"></script>
<script type="text/javascript" src="modules/mod_smallFruitInsertion/js/uploader.js"></script>
<script type="text/javascript" src="libraries/jqueryCustomUI/js/jquery-ui-timepicker-addon.min.js"></script>
<script type="text/javascript" src="js/select2.min.js"></script>
<?php if($edit){ ?>
<script>
	var headers = <?php echo json_encode($headers);?>;
	var tmls = <?php echo $handler->getTms()?json_encode($handler->getTms()):'false';?>;
	var gradeSamples = <?php echo $handler->getSamples()?json_encode($handler->getSamples()):'false'?>;
	var gradeStats = <?php echo $handler->getGradeStats()?json_encode($handler->getGradeStats()):'false'?>;
	var crsSamples = <?php echo $crs['samples']?json_encode($crs['samples']):'false' ?>;
	var crsStat = <?php echo $crs['stat']?json_encode($crs['stat']):'false'?>;
	var belongs = <?php echo $handler->getBalanceSheet()?json_encode($handler->getBalanceSheet()):'false'?>;
	
</script>
<script type="text/javascript" src="modules/mod_smallFruitInsertion/js/updatee.js"></script>
<?php }?>
<style type="text/css">
#ui-datepicker-div 
{
 z-index:20000; /* must be > than popup editor (950) */
}
</style>

<div id="image-upload-index"></div>
<div id="showSug"></div>
<div id="showSugCenter"></div>
<div id='loading-div'>
	<img alt="" height="100" width="100" src="modules/mod_insertionData/images/FireFoxLoading.gif">
</div>
<h3>Gherkin Quality Testing Data Insertion</h3>
<div id="balanceSheetDiv" >
<?php include_once __DIR__.'/includes/balancesheet.php';?>
</div>
<div id="printContainer" style="display:none">
<?php include_once 'modules/mod_smallFruitInsertion/includes/qrPrint.php'; ?>
</div>
<div id="print-BalanceSheetContainer" style="position:absolute;background:#fff;z-index:10000; display:none">
<?php include 'modules/mod_smallFruitInsertion/ajax/print-balanceSheet.php';?>
</div>
<div id="wrapper-insertion">
<div id="headertable">
<div id="tmButton">Get TM Table</div>
<div id="tableDiv"> 
<table id="centerTableSmall" cellpadding="0" cellspacing="0"  border="1" style="width:570px">
	<tr height="25" style="background-color:#ccc;font-weight: bold; " >
		<td width="120">Center</td>
		<td width="120">TM No</td>
		<td colspan="5">Grade</td>
	</tr>
	<tr height="25" style="background-color:#ccc;font-weight: bold; ">
		<td></td>
		<td></td>
		<td id='gr1' >11.0-14.5</td>
		<td id='gr2' >14.5-17.0</td>
		<td id='gr3' >17.0-29.0</td>
		<td id='gr4' >29.0-44.0</td>
		<td id='gr4' >CRS</td>
	</tr>
	<?php 
	for($i=0;$i<20;$i++){ ?>
	<tr height='25'>
			<td>
				<input type='text' id='center<?php echo $i; ?>' 
					style='width:110px' 
					onblur='hideDiv2(this.id)' 
					onkeyup='getCenter(this.value,<?php echo $i; ?>,event)' />
			</td>
			<td>
				<input type='text' id='tm<?php echo $i; ?>' 
						onblur="keyEvent('tm',<?php echo $i; ?>,event)" 
						style='width:110px' />
			</td>
			<td>
				<input type='text' id='gr-<?php echo $i; ?>-1' 
						onblur="keyEvent('1',<?php echo $i; ?>,event)" 
						style='width:70px' />
			</td>
			<td>
				<input type='text' id="gr-<?php echo $i; ?>-2"
						onblur="keyEvent('2',<?php echo $i; ?>,event)" 
						style='width:70px' />
			</td>
			<td>
				<input type='text' id='gr-<?php echo $i; ?>-3' 
						onblur="keyEvent('3',<?php echo $i; ?>,event)" 
						style='width:70px' />
			</td>
			<td>
				<input type='text' id='gr-<?php echo $i; ?>-4' 
						onblur="keyEvent('4',<?php echo $i; ?>,event)" style='width:70px' />
			</td>
			<td>
				<input type='text' id='gr-<?php echo $i; ?>-5' 
						onblur="keyEvent('5',<?php echo $i; ?>,event)" 
						style='width:70px' />
			</td>
		</tr>	
	<?php } ?>
	</table>
</div>
</div>
<div id="navigator">
</div>
<?php 
	$user = new user();
    $userid = $user->getUserID();
	$db = new HDatabase();
	$db->connect();
    $db->select('qa_station','stationId,stationName',"inchargePersonId='$userid'");
    $res = $db->getResult();
    $station;
    foreach ($res as $temp){
     	$station = $temp['stationId'];
    } 
    
	?>
<input type="hidden" id="userId" name="userId" value="<?php echo $userid?>"/>
<input type="hidden" id="print-centerName" name="print-centerName" value="<?php echo $station?>"/>
<div id="slider-wrapper">
<div id="sliderContainerSmall">
<div id="animateDiv-0" class="animate-div" style="position: absolute;width:1000px;height:600px;background-color:#fff;right:0px;z-index: 1000;">
	<div class="toolbar">
		<label>
			<input type="checkbox" id="toggler-0" class="toggler" />
			Consider as sample wise calculation
		</label>
		<input type="hidden" name="sample-fc" id="sample-fc-0"  value="<?php echo $grades[0]['sampleWeight']; ?>">
		<p>Accepted Fruit Count<span id="avg-fc-0"></span></p>
	</div>
</div>  
<div id="animateDiv-1" class="animate-div" style="position: absolute;width:0px;height:600px;background-color:#fff;right:0px;z-index: 4000;" >
	<div class="toolbar">
		<label>
			<input type="checkbox" id="toggler-1" class="toggler" />
			Consider as sample wise calculation
		</label>
		<input type="hidden" name="sample-fc" id="sample-fc-1" value="<?php echo $grades[1]['sampleWeight']; ?>">
		<p>Accepted Fruit Count<span id="avg-fc-1"></span></p>
	</div>
</div>
<div id="animateDiv-2" class="animate-div" style="position: absolute;width:0px;height:600px;background-color:#fff;right:0px;z-index: 6000; " >
	<div class="toolbar">
		<label>
			<input type="checkbox" id="toggler-2" class="toggler" checked="checked"/>
			Consider as sample wise calculation
		</label>
		<input type="hidden" name="sample-fc" id="sample-fc-2" value="<?php echo $grades[2]['sampleWeight']; ?>">
		<p>Accepted Fruit Count<span id="avg-fc-2"></span></p>
	</div>
</div>
<div id="animateDiv-3" class="animate-div" style="position: absolute;width:0px;height:600px;background-color:#fff;right:0px;z-index: 10000;" >
	<div class="toolbar">
		<label>
			<input type="checkbox" id="toggler-3" class="toggler" checked="checked"/>
			Consider as sample wise calculation
		</label>
		<input type="hidden" name="sample-fc" id="sample-fc-3" value="<?php echo $grades[3]['sampleWeight']; ?>">
		<p>Accepted Fruit Count<span id="avg-fc-3"></span></p>
	</div>
</div>
<div id="animateDiv-4" class="animate-div" style="position: absolute;width:0px;height:800px;background-color:#fff;right:0px;z-index: 12000;" >
	
</div>



</div>
<p id="transportCondition-link"  onclick="displayTable();">View Transport Condition table</p>
<div id="transportCondition" style="display:none">
<form action="" id="form6">
<table cellpadding="0" cellspacing="0">
  <tr>
    <th>Transportation Condition</th>
    <th>Status</th>
    <th>Required Status</th>
  </tr>
  <tr>
    <td>Delivery</td>
    <td><input type="radio" name="delivery" value="1" checked="checked">Yes <input type="radio" name="delivery" value="0">No</td>
    <td>Before 3.00 pm</td>
  </tr>
   <tr>
    <td>Lorry cover</td>
    <td><input type="radio" name="cover" value="1" checked="checked" >Yes <input type="radio" name="cover" value="0">No</td>
    <td>Should be covered properly</td>
  </tr>
   <tr>
    <td>Unusual odour inside the truck</td>
    <td><input type="radio" name="smell" value="1" >Yes <input type="radio" name="smell" value="0" checked="checked">No</td>
    <td>Should not present</td>
  </tr>
   <tr>
    <td>Things ather than gherkin</td>
    <td><input type="radio" name="otherThings" value="1">Yes <input type="radio" name="otherThings" value="0" checked="checked">No</td>
    <td>Should not present </td>
  </tr>
   <tr>
    <td>Labels/Color codes</td>
    <td><input type="radio" value="1" name="colorcode" checked="checked">Yes <input type="radio"   name="colorcode" value="0">No</td>
    <td>Should present</td>
  </tr>
   <tr>
    <td>Quality report</td>
    <td><input type="radio" name="qualityReport" value="1" checked="checked" >Yes <input type="radio" name="qualityReport" value="0">No</td>
    <td>Should present</td>
  </tr>
</table>
<a  id="close-link" onclick="closeTransportCondition()">Close</a>
</form>
</div>
<p id="imageuploader-link" onclick="viewImageUploader()"  > Attach Photos <p>
<div id="imageUploaderDiv" style="display:none">
<form enctype="multipart/form-data" action="upload.php" method="POST">
 Please choose a file:
  <div id="container-uploader">
    <div id="filelist">No runtime found.</div>
    <br />
    <input type="button" id="pickfiles" href="javascript:;" class='buttons-' value="Select files">
    <a id="keep-away" onclick='keepAway()' href="javascript:" class='buttons-'>Keep to Upload</a> 
    <input type="button" id="reset-button" href="javascript:;" class='buttons-' value="Reset">
</div>
 </form> 
</div>
<input type="hidden" id="userId" name="userId" value="<?php echo $userid?>"/>
<input type="hidden" id="print-centerName" name="print-centerName" value="<?php echo $station?>"/>
</div>
<div id='loading-div'>
<img alt="" height="100" width="100" src="modules/mod_insertionData/images/FireFoxLoading.gif">
</div>