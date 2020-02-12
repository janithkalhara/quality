<?php defined("HEXEC") or die("Restrited Access."); ?>
<?php require_once 'libraries/base/project/lib_project.php'; ?>
<?php require_once 'includes/HDatabase.php'; ?>
<script type="text/javascript">
var mode='<?php (isset($_GET['action'])&& $_GET['action']=='edit')?print "EDIT":print "INSERT"?>';
var reductions = [];
var numberOfGrades = 0;
</script>
<style>
#ui-datepicker-div{z-index:20000; /* must be > than popup editor (950) */}
</style>
<link rel='stylesheet' type="text/css" href="modules/mod_insertionData/css/insertionData.css" />
<link rel='stylesheet' type="text/css" href="css/select2.css" />
<script type="text/javascript" src="modules/mod_insertionData/js/tablePrinter.js"></script>
<script type="text/javascript" src="modules/mod_insertionData/js/tableAnalyzer.js"></script>
<script type="text/javascript" src="modules/mod_insertionData/js/tableWizard.js"></script>
<script type="text/javascript" src="modules/mod_insertionData/js/insertionData.js"></script>
<script type="text/javascript" src="modules/mod_insertionData/js/tableSupporter.js"></script>
<script type="text/javascript" src="libraries/jqueryCustomUI/js/jquery-ui-timepicker-addon.min.js"></script>
<script type="text/javascript" src="js/select2.min.js"></script>
<?php
if(isset($_GET['action'])){
	require_once 'modules/mod_insertionData/includes/editHelper.php';
	$flag=$_GET['action'];
	switch ($flag){
		case "edit":
			$id = urldecode($_GET['id']);
			$ids = json_decode($id);
			$project = $ids[0];
			$vehicleNo = $ids[1];
			$date = $ids[2];
			$editHelper = new EditHelper($project,$vehicleNo,$date);
			$editHelper->initialize();
			break;
	}
}

function initEdit($p,$v,$d){
	$p = new Project();
	$pname = $p->getProjectNameById($p);
	$projectName = $pname['areaId'];
	$config = array("projectName"=>$projectName);
}

$projects = Project::getProjectsv2(true);
?>
<h3>Gherkin Quality Testing Data Insertion</h3>
<div id='loading-div'>
	<img alt="" height="100" width="100" src="modules/mod_insertionData/images/FireFoxLoading.gif">
</div>
<div id="showSug"></div>
<div id="showSugCenter"></div>
<div id='topPane'>
	<table id="table-toppane" width="990px" >
		<tr>
			<td>Date:</td>
			<td><input type="text" id="date-toppane" style="width:150px;height: 18px" /></td>
			<td width="80px" style="padding-top: 35px" >Center :</td>
			<td width="300px" rowspan="2">
				<div id="centerName" style="position:relative; background-color: white;" >
					<table class="centerTable" style="border:2px solid #ccc">
						<tr>
						<?php foreach (range(1,7) as $i) { ?>
							<td style='height:14px; text-align:center'><?php echo $i; ?></td>
						<?php } ?>
						</tr>
						<tr>
						<?php foreach (range(1,7) as $i) { ?>
						<td><input type='text' style='width:80px;height:14px' disabled='disabled' class='centerName' id="centerName<?php echo $i; ?>" ></td>
						<?php } ?>
						</tr>
						<tr>
						<?php foreach (range(1,7) as $i){ ?>
						<td><input type="text" id="<?php echo $i; ?>-tmToppane" style="width:80px;height:14px" disabled="disabled" /></td>
						<?php }?>
						</tr>
										
					</table>		
				</div>
			</td> 
		</tr>
		<tr height="35px">
			<td>Project: </td>
			<td>
				<select id="project-toppane" >
					<option>Select a project</option>
					<?php foreach ($projects as $p) { ?>
					<option value="<?php echo $p['areaId']; ?>" 
							data-id="<?php echo $p['gradeid']; ?>" 
							data-gradename="<?php echo $p['gradeName']; ?>" 
							data-aname="<?php echo $p['areaName']; ?>"><?php echo $p['areaName']; ?></option>
					<?php } ?>
				</select>
				
				
				<!-- <input type="text" id="project-toppane" style="width:150px;height: 18px" onblur="hideDiv()"/> -->
				
				<input type="hidden" id="project-hidden-toppane"    />
			</td>
			<td>TM No: </td>
		</tr>
		<tr>
			<td>Vehicle No: </td>
			<td><input type="text" id="vehicle-toppane" style="width:150px;height: 18px" /></td>
			<td></td>
			<td></td>
			<?php 
			$user = new user();
		    $userid = $user->getUserID();
			$db = new HDatabase();
			$db->connect();
		    $db->select('qa_station','stationName',"inchargePersonId='$userid'");
		    $res = $db->getResult();
		    $station;
		     foreach ($res as $temp){
		     	$station = $temp['stationName'];
		     } 
			?>
		</tr>
	</table>
	<input type="hidden" id="userId" name="userId" value="<?php echo $userid?>"/>
	<input type="hidden" id="print-centerName" name="print-centerName" value="<?php echo $station?>"/>
	<input type="hidden" id="numberOfGrades" name="numberOfGrades" value=""/>
	<button id="tmTable-link" class="btn btn-primary"><i class="icon icon-table"></i> Get TM table</button>
	
	<table id="centerTable" cellpadding="0" cellspacing="0"  border="1" >
		<tr height="25" style="background-color:#ccc;font-weight: bold; " >
			<td width="120">Center</td>
			<td width="120">TM No</td>
			<td colspan="4">Grade</td>
		</tr>
		<tr height="25" style="background-color:#ccc;font-weight: bold; ">
			<td></td>
			<td></td>
			<td id='gr1' >1</td>
			<td id='gr2' >2</td>
			<td id='gr3' >3</td>
			<td id='gr4' >4</td>
		</tr>
	<?php foreach (range(0,20) as $i) { ?>
	<tr height='25'>
		<td>
			<input type='text' id='center<?php echo $i; ?>' style='width:110px' onblur='hideDiv2(this.id)' onkeyup='getCenter(this.value,<?php echo $i; ?>,event)' />
		</td>
		<td>
			<input type='text' id='tm<?php echo $i; ?>' onkeyup="keyEvent('tm',<?php echo $i; ?>,event)" style='width:110px' />
		</td>
		<td>
			<input type='text' id='gr-<?php echo $i; ?>-1' onkeyup="keyEvent('1',<?php echo $i; ?>,event)" onblur=checkVal(this.id) style='width:70px' />
		</td>
		<td>
			<input type='text' id='gr-<?php echo $i; ?>-2' onkeyup="keyEvent('2',<?php echo $i; ?>,event)" style='width:70px' />
		</td>
		<td>
			<input type='text' id='gr-<?php echo $i; ?>-3' onkeyup="keyEvent('3',<?php echo $i; ?>,event)" style='width:70px' />
		</td>
		<td>
			<input type='text' id='gr-<?php echo $i; ?>-4' onkeyup="keyEvent('4',<?php echo $i; ?>,event)" style='width:70px' />
		</td>
	</tr>
	<?php }?>
	</table>
	<div id="buttonWrapper">
		<table>
			<tr>
				<td>
					<input type="button" id="butOne" value="1" class="ui-state-default ui-corner-all" />
				</td>
				<td>
					<input type="button" id="butTwo" value="2" class="ui-state-default ui-corner-all" />
				</td>
				<td>
					<input type="button" id="butThree" value="3" class="ui-state-default ui-corner-all" />
				</td>
				<td>
					<input type="button" id="butFour" value="4" class="ui-state-default ui-corner-all" /> 
				</td>
				<td>
					<select class="ui-state-default ui-corner-all"  id="selectGrade" disabled="disabled" style="position: relative; width: 130px; height: 30px; left: 0px;font-size: 14px; background:#333" >
							<?php   
								$con = new HDatabase();
								$con->connect();
								$con->select('qa_gradeCategory','*');
								$result = $con->getResult();
								foreach ($result as $r){
									echo '<option value="'.$r['id'].'" class="ui-state-default ui-corner-all">'.$r['name'].'							                                </option>';
								}
						?>
					</select>
				</td>
			</tr>
		</table>
	</div>
</div>
<div id="indexContainer">
<?php 
$browserM;
function agent($browser) {
	$useragent = $_SERVER['HTTP_USER_AGENT'];
	return strstr($useragent,$browser);
}

if(agent("Firefox") != false) {
	$browserM = 'firefox';
}
else if(agent("Chrome") != false) {
	$browserM = 'chrome';
}
else{
	$browserM = "chrome";
}
include "modules/mod_insertionData/sidebarTable-".$browserM.".php"?>
</div>
<div id="sliderContainer">
	<div id="animateDiv1" style="position: absolute;width:0px;height:680px;background-color:#fff;right:0px;z-index: 10000;" ></div>
	<div id="animateDiv2" style="position: absolute;width:0px;height:680px;background-color:#fff;right:0px;z-index: 6000; " ></div>
	<div id="animateDiv3" style="position: absolute;width:0px;height:680px;background-color:#fff;right:0px;z-index: 4000;" ></div>
	<div id="animateDiv4" style="position: absolute;width:770px;height:680px;background-color:#fff;right:0px;z-index: 1000; " ></div>
	<!--  <input type="submit" onclick="submitMe()" id='submit-me' value="Submit Data" style="z-index: 10200;position: relative; top:650px; cursor:pointer;"  />
	<input type="reset"  onclick="resetMe()" id="reset-me"value=" Reset " style="z-index: 10200; position: relative; top:650px;cursor:pointer; "  />
	<input type="button" onclick="printMe()" id="print-me" value="Print the Report" style="z-index: 10200; position: relative; top:650px;cursor:pointer; " >
	 -->
</div>
	<div class="action-panel">
	<button class="btn btn-primary" onclick="submitMe()" id='submit-me'  ><i class="icon icon-save"></i>  Submit Data</button>
	<button class="btn btn-primary" onclick="resetMe()" id="reset-me"><i class="icon icon-undo"></i>  Reset</button>
	<button class="btn btn-primary" onclick="printMe()" id="print-me"><i class="icon icon-print"></i> Print</button>
	</div>
<style type="text/css">
	@media print{
		
	#printArea{ width:960px;height:1120px; border:1pt solid #000000; display:block}
	#printArea table .data-print{
	        width:1040px;height:250px
	}
	#printArea table td{
	        width:18px;padding:0px; height:8px;font-size:12px
	}
	#printArea table span{
	         font-size:8px ; padding:0px
	}
	
	#printArea table .datatable-sum{
	        width:250px; border:1px solid #333; margin:2px;height:130px
	}
	
	#printArea table .datatable-sum td{
	       line-height: 1px;
	}
	
	#headertable{ height:30px;position:relative; margin-top:50px}
	
	#transportqualitytable{ position: relative;float: left;top:-340px}
	
	#side2{height:160px}
	
	.rowspanned{ -webkit-transform: rotate(-90deg); 
	-moz-transform: rotate(-90deg);
	filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);
	transform:rotate(-90deg); fov>
		<dint-size:6px;font-weight:bold}
	}
</style>
<div id="printArea"  style=" display:none; margin:auto; position:absolute; background:#fff; z-index:400000; left: 67px; height: 1325px; border:2pt solid #000; ">
<tr>
<td height="40">&nbsp;</td>
</tr>
 <table width="870" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse; font-size:10px">
    <tr>
      <td align="center" width="250"><strong>HJS</strong> <strong>Condiments Limited <br />
      SunFrost (PVT) LTD</strong></td>
      <td  align="center" ><strong>ගර්කින් තත්ව පරීක්ෂණ වාර්තාව (Medium,Large and CRS Grades)</strong></td>
      <td align="center">Issue No:01 <br>Issue Date: 23.09.2011</td>
    </tr>
  </table>
  <table width="870" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse; font-size:10px">
    <tr>
      <td width="225" height="20">ගෙඩි භාරගත් ස්ථානය<span style="position:relative;float:right;right:10px" id="stationName"></span></td>
      <td width="179"> දිනය :    <span style="position:relative;float:right;right:10px" id="print_date"></span></td>
      <td width="65"> ව්‍යාපෘතිය :  </td>
      <td width="181" id="print-project">&nbsp;</td>
      <td width="68"> වාහන අංකය : </td>
      <td width="138" id="print-vehicle">&nbsp;</td>
    </tr>
  </table>
  <table width="870" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse; font-size:10px">
  <tr>
    <td colspan="7" width="160" >&nbsp;</td>
    <td colspan="2"> ශ්‍රේණිය </td>
    <td colspan="2" id="1-print-grade">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="4"> අනුමත ගෙඩි ගණන </td>
    <td colspan="3" id="1-print-avgFruitCount">&nbsp;</td>
    <td width="23"> එකතුව </td>
    <td width="23">%</td>
    <td rowspan="25" width="4">&nbsp;</td>
    <td colspan="2">ශ්‍රේණිය</td>
    <td colspan="2" id="2-print-grade">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="4">අනුමත ගෙඩි ගණන</td>
    <td colspan="3" id="2-print-avgFruitCount">&nbsp;</td>
    <td width="23">එකතුව</td>
    <td width="23">%</td>
  </tr>
  <tr>
    <td colspan="7"> මධ්‍යස්ථාන අංකය </td>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='1-print-slot-0-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='2-print-slot-0-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
  </tr>
  <tr>
    <td colspan="7"> ගෙඩි ගණන </td>
	<?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='1-print-slot-1-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='2-print-slot-1-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
  </tr>
  <tr>
    <td colspan="3" rowspan="2"> වැරදි <br /> ශ්‍රේණිය </td>
    <td colspan="4"> කුඩා ගෙඩි ගණන </td>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='1-print-slot-2-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='2-print-slot-2-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
  </tr>
  <tr>
    <td colspan="4"> ලොකුගෙඩි ගණන </td>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='1-print-slot-3-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='2-print-slot-3-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
  </tr>
  <tr>
    <td colspan="3" rowspan="5"> ප්‍රධාන දෝෂ<br />(ගෙඩි ගණන) </td>
    <td colspan="4"> ඉල් මැසි හානි </td>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='1-print-slot-4-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='2-print-slot-4-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
  </tr>
  <tr>
    <td colspan="4"> පොතු ගැලවුණු </td>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='1-print-slot-5-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='2-print-slot-5-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
  </tr>
  <tr>
    <td colspan="4"> පණු කුහර හානි </td>
   	<?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='1-print-slot-6-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='2-print-slot-6-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
  </tr>
  <tr>
    <td colspan="4"> වැලි සහිත </td>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='1-print-slot-7-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='2-print-slot-7-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
  </tr>
  <tr>
    <td colspan="4"> හැකිළුණු ගෙඩි </td>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='1-print-slot-8-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='2-print-slot-8-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
  </tr>
  <tr>
    <td colspan="3" rowspan="6"> ප්‍රධාන නොවන <br />දෝෂ<br /> (ගෙඩි ගණන) </td>
    <td colspan="4"> හැඩය වෙනස් </td>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='1-print-slot-9-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='2-print-slot-9-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
  </tr>
  <tr>
    <td colspan="4"> වෛරස් ආසාදිත </td>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='1-print-slot-10-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='2-print-slot-10-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
  </tr>
  <tr>
    <td colspan="4"> යාන්ත්‍රික හානි </td>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='1-print-slot-11-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='2-print-slot-11-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
  </tr>
  <tr>
    <td colspan="4"> කහ පැහැති ගෙඩි </td>
     <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='1-print-slot-12-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='2-print-slot-12-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
  </tr>
  <tr>
    <td colspan="4"> දුඹුරු පැල්ලම් </td>
   <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='1-print-slot-13-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='2-print-slot-13-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
  </tr>
  <tr>
    <td colspan="4">45mmට වැඩි</td>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='1-print-slot-14-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='2-print-slot-14-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
  </tr>
  <tr>
    <td colspan="7"> පිළිගත් (AC)/නොපිළිගත්(RJ) </td>
  	<?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='1-print-slot-15-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='2-print-slot-15-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
  </tr>
  <tr>
    <td colspan="7"> නරක් වු ගෙඩි </td>
   	<?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='1-print-slot-16-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='2-print-slot-16-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
    
  </tr>
  <tr>
    <td colspan="7" rowspan="7">&nbsp;</td>
    <td colspan="6"> ක්‍රේට් ගණන </td>
    <td colspan="4" align="center" id="1-print-sum-noCrates">&nbsp;</td>
    <td colspan="5" rowspan="7">&nbsp;</td>
    <td colspan="6">ක්‍රේට් ගණන </td>
    <td colspan="4" align="center" id="2-print-sum-noCrates">&nbsp;</td>
    <td colspan="5" rowspan="7">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="6"> ප්‍රකාශිත බර(kg) </td>
    <td colspan="4" align="center" id="1-print-sum-notedWeight">&nbsp;</td>
    <td colspan="6">ප්‍රකාශිත බර(kg) </td>
    <td colspan="4" align="center" id="2-print-sum-notedWeight">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="6"> තිබූ බර ප්‍රමාණය(kg) </td>
    <td colspan="4" align="center" id="1-print-sum-trueWeight">&nbsp;</td>
    <td colspan="6">තිබූ බර ප්‍රමාණය(kg) </td>
    <td colspan="4" align="center" id="2-print-sum-trueWeight">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="6" align="center">&nbsp;</td>
    <td colspan="2" align="center">එකතුව</td>
    <td colspan="2" align="center">අඩු කල %</td>
    <td colspan="6" align="center">&nbsp;</td>
    <td colspan="2" align="center">එකතුව</td>
    <td colspan="2" align="center">අඩු කල %</td>
    </tr>
  <tr>
    <td colspan="6"> වැරදි ශ්‍රේණිය </td>
    <td colspan="2" id="1-print-sum-defectGrade-sum">&nbsp;</td>
    <td colspan="2" id="1-print-sum-defectGrade-reduced">&nbsp;</td>
    <td colspan="6">වැරදි ශ්‍රේණිය </td>
    <td colspan="2" id="2-print-sum-defectGrade-sum">&nbsp;</td>
    <td colspan="2"  id="2-print-sum-defectGrade-reduced">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="6"> දෝෂ </td>
    <td colspan="2" id="1-print-sum-defects-sum">&nbsp;</td>
    <td colspan="2" id="1-print-sum-defects-reduced">&nbsp;</td>
    <td colspan="6">දෝෂ </td>
    <td colspan="2" id="2-print-sum-defects-sum">&nbsp;</td>
    <td colspan="2" id="2-print-sum-defects-reduced">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="6"> ගෙවිය හැකි ප්‍රමාණය(kg) </td>
    <td colspan="2" id="1-print-sum-pq-sum">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="6">ගෙවිය හැකි ප්‍රමාණය(kg) </td>
    <td colspan="2" id="2-print-sum-pq-sum">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    </tr>
</table>
  <table width="870" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse; font-size:10px">
  <tr>
    <td colspan="7" width="160" >&nbsp;</td>
    <td colspan="2"> ශ්‍රේණිය </td>
    <td colspan="2"  id="3-print-grade">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="4"> අනුමත ගෙඩි ගණන </td>
    <td colspan="3" id="3-print-avgFruitCount" >&nbsp;</td>
    <td width="23"> එකතුව </td>
    <td width="23">%</td>
    <td rowspan="25" width="4">&nbsp;</td>
    <td colspan="2">ශ්‍රේණිය</td>
    <td colspan="2" id="4-print-grade" >&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="4" >අනුමත ගෙඩි ගණන</td>
    <td colspan="3" id="4-print-avgFruitCount">&nbsp;</td>
    <td width="23">එකතුව</td>
    <td width="23">%</td>
  </tr>
  <tr>
    <td colspan="7"> මධ්‍යස්ථාන අංකය </td>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='3-print-slot-0-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='4-print-slot-0-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
  </tr>
  <tr>
    <td colspan="7"> ගෙඩි ගණන </td>
     <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='3-print-slot-1-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='4-print-slot-1-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
  </tr>
  <tr>
    <td colspan="3" rowspan="2"> වැරදි <br />
      ශ්‍රේණිය </td>
    <td colspan="4"> කුඩා ගෙඩි ගණන </td>
     <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='3-print-slot-2-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='4-print-slot-2-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
  </tr>
  <tr>
    <td colspan="4"> ලොකුගෙඩි ගණන </td>
     <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='3-print-slot-3-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='4-print-slot-3-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
  </tr>
  <tr>
    <td colspan="3" rowspan="5"> ප්‍රධාන දෝෂ<br />
      (ගෙඩි ගණන) </td>
    <td colspan="4"> ඉල් මැසි හානි </td>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='3-print-slot-4-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='4-print-slot-4-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
  </tr>
  <tr>
    <td colspan="4"> පොතු ගැලවුණු </td>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='3-print-slot-5-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='4-print-slot-5-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
  </tr>
  <tr>
    <td colspan="4"> පණු කුහර හානි </td>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='3-print-slot-6-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='4-print-slot-6-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
  </tr>
  <tr>
    <td colspan="4"> වැලි සහිත </td>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='3-print-slot-7-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='4-print-slot-7-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
  </tr>
  <tr>
    <td colspan="4"> හැකිළුණු ගෙඩි </td>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='3-print-slot-8-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='4-print-slot-8-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
  </tr>
  <tr>
    <td colspan="3" rowspan="6"> ප්‍රධාන නොවන <br/>දෝෂ<br />(ගෙඩි ගණන) </td>
    <td colspan="4"> හැඩය වෙනස් </td>
     <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='3-print-slot-9-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='4-print-slot-9-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
  </tr>
  <tr>
    <td colspan="4"> වෛරස් ආසාදිත </td>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='3-print-slot-10-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='4-print-slot-10-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
  </tr>
  <tr>
    <td colspan="4"> යාන්ත්‍රික හානි </td>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='3-print-slot-11-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='4-print-slot-11-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
  </tr>
  <tr>
    <td colspan="4"> කහ පැහැති ගෙඩි </td>
   	<?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='3-print-slot-12-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='4-print-slot-12-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
  </tr>
  <tr>
    <td colspan="4"> දුඹුරු පැල්ලම් </td>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='3-print-slot-13-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='4-print-slot-13-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
  </tr>
  <tr>
    <td colspan="4">45mmට වැඩි</td>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='3-print-slot-14-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='4-print-slot-14-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
  </tr>
  <tr>
    <td colspan="7"> පිළිගත් (AC)/නොපිළිගත්(RJ) </td>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='3-print-slot-15-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='4-print-slot-15-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
  </tr>
  <tr>
    <td colspan="7"> නරක් වු ගෙඩි </td>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='3-print-slot-16-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
    <?php foreach (range(0,15) as $i) { ?>
    <td width='23' id='4-print-slot-16-<?php echo $i; ?>'>&nbsp;</td>
    <?php } ?>
  </tr>
  <tr>
    <td colspan="7" rowspan="7">&nbsp;</td>
    <td colspan="6" > ක්‍රේට් ගණන </td>
    <td colspan="4"  align="center" id="3-print-sum-noCrates">&nbsp;</td>
    <td colspan="5" rowspan="7">&nbsp;</td>
    <td colspan="6">ක්‍රේට් ගණන </td>
    <td colspan="4" align="center" id="4-print-sum-noCrates">&nbsp;</td>
    <td colspan="5" align="center"rowspan="7">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="6"> ප්‍රකාශිත බර(kg) </td>
    <td colspan="4" align="center" id="3-print-sum-notedWeight">&nbsp;</td>
    <td colspan="6">ප්‍රකාශිත බර(kg) </td>
    <td colspan="4" align="center" id="4-print-sum-notedWeight">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="6"> තිබූ බර ප්‍රමාණය(kg) </td>
    <td colspan="4" align="center" id="3-print-sum-trueWeight">&nbsp;</td>
    <td colspan="6">තිබූ බර ප්‍රමාණය(kg) </td>
    <td colspan="4" align="center" id="4-print-sum-trueWeight">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="6">&nbsp;</td>
    <td colspan="2" align="center">එකතුව</td>
    <td colspan="2" align="center">අඩු කල %</td>
    <td colspan="6">&nbsp;</td>
    <td colspan="2" align="center">එකතුව</td>
    <td colspan="2" align="center" >අඩු කල %</td>
    </tr>
  <tr>
    <td colspan="6"> වැරදි ශ්‍රේණිය </td>
    <td colspan="2" align="center" id="3-print-sum-defectGrade-sum">&nbsp;</td>
    <td colspan="2" align="center" id="3-print-sum-defectGrade-reduced">&nbsp;</td>
    <td colspan="6">වැරදි ශ්‍රේණිය </td>
    <td colspan="2" align="center" id="4-print-sum-defectGrade-sum">&nbsp;</td>
    <td colspan="2" align="center" id="4-print-sum-defectGrade-reduced">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="6"> දෝෂ </td>
    <td colspan="2" align="center" id="3-print-sum-defects-sum">&nbsp;</td>
    <td colspan="2" align="center" id="3-print-sum-defects-reduced">&nbsp;</td>
    <td colspan="6">දෝෂ </td>
    <td colspan="2" align="center" id="4-print-sum-defects-sum">&nbsp;</td>
    <td colspan="2" align="center" id="4-print-sum-defects-reduced">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="6"> ගෙවිය හැකි ප්‍රමාණය(kg) </td>
    <td colspan="2" align="center" id="3-print-sum-pq-sum">&nbsp;</td>
    <td colspan="2" align="center">&nbsp;</td>
    <td colspan="6" >ගෙවිය හැකි ප්‍රමාණය(kg) </td>
    <td colspan="2" align="center" id="4-print-sum-pq-sum">&nbsp;</td>
    <td colspan="2" align="center">&nbsp;</td>
    </tr>
</table>
  <table width="870" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse ;font-size:10px">
    <tr  height="2">
      <td  height="2" colspan="33">&nbsp;</td>
    </tr>
    <tr>
      <td width="150"> ප්‍රවාහන තත්වය </td>
      <td colspan="2"> විස්තරය </td>
      <td colspan="7"> අවශ්‍ය තත්වය </td>
      <td width="8" rowspan="7">&nbsp;</td>
      <td colspan="3"> මධ්‍යස්ථාන අංකය </td>
      <td colspan="4"> මධ්‍යස්ථානය </td>
      <td colspan="3"> TM අංකය </td>
      <td width="8" rowspan="7">&nbsp;</td>
      <td colspan="4"> තොගයේ ප්‍රමාණය(crates/bags) </td>
      <td colspan="3"> සාම්පලයේ ප්‍රමාණය </td>
      <td colspan="4"> තිබිය හැකි උපරිම මට්ටම </td>
    </tr>
    <tr>
      <td> බාර දීම </td>
      <td colspan="2" id="print-delivery">&nbsp;</td>
      <td colspan="7"> සවස 3.00ට පෙර </td>
      <td colspan="3" align="center">1</td>
      <td colspan="4" id="print-center-1">&nbsp;</td>
      <td colspan="3" id="print-tm-1">&nbsp;</td>
      <td colspan="4" align="center"> 2-90 </td>
      <td colspan="3" align="center">5</td>
      <td colspan="4" align="center">1</td>
    </tr>
    <tr>
      <td height="17" > ලොරිය ආවරණය </td>
      <td colspan="2" id="print-lorryCover">&nbsp;</td>
      <td colspan="7"> හොඳින් ආවරණය කර තිබිය යුතුයි </td>
      <td colspan="3" align="center">2</td>
      <td colspan="4" id="print-center-2">&nbsp;</td>
      <td colspan="3" id="print-tm-2">&nbsp;</td>
      <td colspan="4" align="center"> 91-150 </td>
      <td colspan="3" align="center">8</td>
      <td colspan="4" align="center">2</td>
    </tr>
    <tr>
      <td> ලොරිය තුළ අනවශ්‍ය දුර්ගන්ධය </td>
      <td colspan="2" id="print-smell">&nbsp;</td>
      <td colspan="7" > නොතිබිය යුතුයි </td>
      <td colspan="3" align="center">3</td>
      <td colspan="4" id="print-center-3">&nbsp;</td>
      <td colspan="3" id="print-tm-3">&nbsp;</td>
      <td colspan="4" align="center"> 151-500 </td>
      <td colspan="3" align="center">13</td>
      <td colspan="4" align="center">3</td>
    </tr>
    <tr>
      <td height="15"> ගර්කින් හැර වෙනත් ද්‍රව්‍ය </td>
      <td colspan="2" id="print-otherThings">&nbsp;</td>
      <td colspan="7" > නොතිබිය යුතුයි </td>
      <td colspan="3" align="center">4</td>
      <td colspan="4" id="print-center-4">&nbsp;</td>
      <td colspan="3" id="print-tm-4">&nbsp;</td>
      <td colspan="11" > තිබිය හැකි උපරිම වැරදි ශ්‍රේණි මට්ටම 10% </td>
    </tr>
    <tr>
      <td> ලේබල්/හඳුනාගැනීමේ වර්ණ සංකේත </td>
      <td colspan="2" id="print-colorCode">&nbsp;</td>
      <td colspan="7" > තිබිය යුතුයි </td>
      <td colspan="3" align="center">5</td>
      <td colspan="4" id="print-center-5" align="center">&nbsp;</td>
      <td colspan="3" id="print-tm-5">&nbsp;</td>
      <td colspan="11"> තිබිය හැකි උපරිම දෝෂ මට්ටම 7% ( නරක් වූ ගෙඩි % හැර) </td>
    </tr>
    <tr>
      <td> තත්ව වාර්තාව </td>
      <td colspan="2" align="center" id="print-qualityReport">&nbsp;</td>
      <td colspan="7" > තිබිය යුතුයි </td>
      <td colspan="3" align="center">6</td>
      <td colspan="4" id="print-center-6" align="center">&nbsp;</td>
      <td colspan="3" id="print-tm-6">&nbsp;</td>
      <td colspan="11" > මුලු නරක් වූ % සම්පූර්ණ තොගයෙන් අඩු කරනු ලැබේ. </td>
    </tr>
  </table>
  <table width="870" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse; font-size:10px">
    <tr>
      <td colspan="10">&nbsp;</td>
    </tr>
    <tr>
      <td width="70" align="center"> ශ්‍රේණිය </td>
      <td width="106" align="center"> අනුමත විශ්කම්භය(mm) </td>
      <td width="103" align="center"> උප සාම්පලයේ ප්‍රමාණය </td>
      <td width="12" rowspan="8">&nbsp;</td>
      <td colspan="6" rowspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">80/160</td>
      <td align="center"> 14-17 </td>
      <td align="center">1</td>
    </tr>
    <tr>
      <td align="center"> 20/80 </td>
      <td align="center"> 17-29 </td>
      <td align="center">2</td>
      <td colspan="6"> නිගමනය : භාරගත හැක/ප්‍රතික්ශේපිත/කොටසක් ප්‍රතික්ශේපිත </td>
    </tr>
    <tr>
      <td align="center">5/20</td>
      <td align="center"> 29-44 </td>
      <td align="center">7</td>
      <td colspan="6"> වෙනත්:......................................................................................................................................................................................................... </td>
    </tr>
    <tr>
      <td align="center"> 15/25(No.2) </td>
      <td align="center"> 24-30 </td>
      <td align="center">5</td>
      <td colspan="6"> පරීක්ෂා කළේ :........................................ නිරීක්ෂණය කළේ :............................................ අනුමත කළේ :.......................................... </td>
    </tr>
    <tr>
      <td align="center"> 10/15(No.3) </td>
      <td align="center"> 30-42 </td>
      <td align="center">5</td>
      <td colspan="6">&nbsp;</td>
    </tr>
    <tr>
      <td height="17" align="center"> 5/10(No.4) </td>
      <td align="center"> 42-45 </td>
      <td align="center">8</td>
      <td colspan="6" rowspan="2"> සටහන: ඉල් මැසි හානි අධික අවස්ථාවේදී එය නිෂ්පාදනය සඳහා යොදාගත නොහැකි බැවින් ,සම්පූර්ණ තොගය සාම්පල් සැලැස්ම නොසලකා හරිමින් ප්‍රතික්ශේප කරනු ලැබේ. </td>
    </tr>
    <tr>
      <td align="center"> CRS </td>
      <td align="center"> 16&lt;--&gt;44 </td>
      <td align="center">5</td>
    </tr>
  </table>
</div>