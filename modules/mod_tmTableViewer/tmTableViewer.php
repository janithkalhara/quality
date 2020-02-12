<?php 
defined("HEXEC") or die("Restrited Access.");
$season_id = isset($_GET['season']) ? $_GET['season'] : null;
$from = isset($_GET['from']) ? $_GET['from'] : null;
$to = isset($_GET['to']) ? $_GET['to'] : null;
$project_id = isset($_GET['project']) ? $_GET['project'] : null
?>
<link rel="stylesheet" type="text/css"
	href="modules/mod_tmTableViewer/css/tmTableViewer.css" />
<script
	type="text/javascript"
	src="modules/mod_tmTableViewer/js/tmTableViewer.js"></script>

<?php $date=date("Y-m-d");
//require_once 'includes/HDatabase.php';

global $import;
$import->importLib('season');
$seasons = new Season();
$season = $seasons->getSeasons();

$import->importLib('grade');
$grades = new Grade();
$grade = $grades->getGrades();

$import->importLib('project');
$projects = new Project();
if($_POST['flag']){
	$project = $projects->getProjectBySeason($_POST['season']);
}
else{
	$project = $projects->getProjects(); 
}
$import->importClass('tmTableViewer','TableCreater');

?>

<div id="outerDiv">
	<h3>Stocks by Date</h3>

	<div id="selectTable">
		<form method="post" action="home.php?option=mod_tmTableViewer"
			id="myform">
			Season : <select id="season" name="season" id="season" >
				<option value="not selected">Select season</option>
				<?php

				if($_POST['season']){
					foreach ($season as $s){
						if($_POST['season'] == $s['seasonId']){
							print "<option selected='selected' value='".$s['seasonId']."'>".$s['seasonName']."</option>";
						}else{						
							print "<option value='".$s['seasonId']."'>".$s['seasonName']."</option>";
						}
					}
				}else{
					foreach ($season as $s){
						print "<option value='".$s['seasonId']."'>".$s['seasonName']."</option>";
					}
				}

				?>

			</select> Station : <select id="stationId" name="stationId">
				<?php 
					if($_POST['flag']){
						if($_POST['stationId'] == "1"){
							echo '<option selected="selected" value="1">HJS</option>';
						}else{
							echo '<option value="1">HJS</option>';
						}
					if($_POST['stationId'] == "2"){
							echo '<option selected="selected" value="2">Alawwa</option>';
						}else{
							echo '<option value="2">Alawwa</option>';
						}
					if($_POST['stationId'] == "3"){
							echo '<option selected="selected" value="3">Padiyathalawa</option>';
						}else{
							echo '<option value="3">Padiyathalawa</option>';
						}
					if($_POST['stationId'] == "Total"){
							echo '<option selected="selected" value="Total">Total</option>';
						}else{
							echo '<option value="Total">Total</option>';
						}	
						
					}else{				
				?>			
				<option value="1">HJS</option>
				<option value="2">Alawwa</option>
				<option value="3">Padiyathalawa</option>
				<option value="Total">Total</option>
				<?php } ?>
			</select> Project : <select name='project' id='project' >
			<?php
			
			if($_POST['flag']) {
				print '<option value="" >Select Project</option>';				
				foreach($project as $b) {
					if($_POST['project'] == $b['areaId'] ) {
						print "<option selected='selected' value='".$b['areaId']."'>".$b['areaName']."</option>";
					}
					else {					
						print "<option value='".$b['areaId']."'>".$b['areaName']."</option>";
					}
				}				
			}
			else {					
				print '<option value="" >Select Project</option>';
			}
			?>
			</select> from : <input type="text" id="startDate" name="startDate" value="<?php echo isset($_POST['startDate']) ? $_POST['startDate'] : $date; ?>"
				/>
			<div style="position: relative; left: 796px; top: -30px">
				to : <input type="text" id="endDate" name="endDate" value="<?php echo isset($_POST['endDate']) ? $_POST['endDate'] : $date; ?>"
					style="width: 90px" />
			</div>
			<input type="hidden" name="flag" value="1">
			<div id="submitBut">Generate Report</div>

		</form>
	</div>
	<hr />
	<?php
	if(isset($_POST['flag'])){
		new TableCreater($_POST);
	}
	?>
	<table id="showDiv">
	<script type="text/javascript">
	var season = '<?php echo $season_id ? $season_id : 'not selected'; ?>';
	var fromdate = '<?php echo $from; ?>';
	var todate = '<?php echo $to; ?>';
	var project = '<?php echo  $project_id ? $project_id : 'not selected'; ?>';
	$(document).ready(function(){
		if(season) {
			$('#season').val(season);
			$('#season').trigger('change');
		}
		$('#stationId').val('Total');
		if(fromdate!='') {	
			$('#startDate').val(fromdate);
		}
		if(todate!='') {	
			$('#endDate').val(todate);
		}

		if(project) {
			$('#project').val(project);
		}
		
		if(season && fromdate!='' && todate!='') {
			setTimeout(function(){
				$('#submitBut').trigger('click');
				},100);
		}
		
	});
	

	</script>
	</table>
	<div id="printDiv"></div>
</div>