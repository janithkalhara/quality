<?php 
global $import;
$import->importLib('season');
$season = new Season();
$seasons = $season->getSeasons();

$import->importLib('project');
$projects = new Project();
$project = "";
if(isset($_POST['flag'])){
	$project = $projects->getProjectBySeasonAndType($_POST['select-season'], $_POST['select-type']);
}else{
	$ongoingSeason = $season->getOngoingSeasonId();
	$project = $projects->getProjectBySeasonAndType($ongoingSeason,"0");
}

$import->importClass('totalQuantityProject', 'ReportGenerator');

?>


<link rel="stylesheet" href="modules/mod_totalQuantityProject/css/totalQuantityProject.css" type="text/css" />

<script type="text/javascript" src="modules/mod_totalQuantityProject/js/totalQuantityProject.js" > </script>

<script type="text/javascript">
<?php
		$date = date("Y-m-d");
?>
</script>


<div id="outerDiv">

	<h3>Total Quantity</h3>
	<div id="selectTable" >
		<form method="post" action="home.php?option=mod_totalQuantityProject" id="dataForm" >
		<table width="970" cellpadding="0" cellspacing="0" border="0">
			<tr align="center" >
				<td>Season</td>
				<td>Station</td>
				<td>Project Type</td>
				<td>Project </td>
				<td>Start Date</td>
				<td>End Date</td>
			</tr>
			<tr align="center" >
				<td>
					<select id="select-season" name="select-season" >
						<?php 
							for($i=0;$i<count($seasons);$i++){
								if(isset($_POST['flag'])){
									if($_POST['select-season'] == $seasons[$i]['seasonId']){		
										print "<option value=".$seasons[$i]['seasonId']." selected='selected' >".$seasons[$i]['seasonName']."</option>";
									}else{
										print "<option value=".$seasons[$i]['seasonId']." >".$seasons[$i]['seasonName']."</option>";
									}
								}else{	
								    if($seasons[$i]['flag'] == "1")
										print "<option value=".$seasons[$i]['seasonId']." selected='selected' >".$seasons[$i]['seasonName']."</option>";
									else 
										print "<option value=".$seasons[$i]['seasonId'].">".$seasons[$i]['seasonName']."</option>";
								}
							}
						
						?>
					</select>					
				</td>
				<td>
					<select id="select-station" name="select-station">
					<?php 
					if(isset($_POST['flag'])){
						if($_POST['select-station'] == "1"){
							echo '<option selected="selected" value="1">HJS</option>';
						}else{
							echo '<option value="1">HJS</option>';
						}
					if($_POST['select-station'] == "2"){
							echo '<option selected="selected" value="2">Alawwa</option>';
						}else{
							echo '<option value="2">Alawwa</option>';
						}
					if($_POST['select-station'] == "3"){
							echo '<option selected="selected" value="3">Padiyathalawa</option>';
						}else{
							echo '<option value="3">Padiyathalawa</option>';
						}
					if($_POST['select-station'] == "TOT"){
							echo '<option selected="selected" value="Total">Total</option>';
						}else{
							echo '<option value="TOT">Total</option>';
						}	
						
					}else{				
				?>
						<option value="1">HJS</option>
						<option value="2">Alawwa</option>
						<option value="3">Padiyathalawa</option>
						<option value="TOT">Total</option>
				<?php }	?>		
						
					</select>				
				</td>
				<td>
					<select id="select-type" name="select-type">
					<?php 
						if(isset($_POST['flag'])){							
							if($_POST['select-type'] == '0'){
								print "<option selected='selected' value='0'>Internal</option>";
							}else{
								print "<option value='0'>Internal</option>";
							}
							if($_POST['select-type'] == '1'){
								print "<option selected='selected' value='1'>External</option>";
							}else{
								print "<option value='1'>External</option>";
							}
							if($_POST['select-type'] == 'TOT'){
								print "<option selected='selected' value='TOT'>Total</option>";
							}else{
								print "<option value='TOT'>Total</option>";
							}						
						}else{
					
					?>
					
						<option value="0">Internal</option>
						<option value="1">External</option>
						<option value="TOT">Total</option>
						<?php } ?>
					</select>
				</td>
				<td>
					<select id="select-project" name="select-project">
					  <?php 
					  	if(isset($_POST['flag'])){
							if($project){
								foreach($project as $p){
									if($_POST['select-project'] == $p['areaId']){
										print "<option selected='selected' value=".$p['areaId'].">".$p['areaName']."</option>";
									}else{
										print "<option value=".$p['areaId'].">".$p['areaName']."</option>";
									}
								}
								if($_POST['select-project'] == "TOT"){
									print "<option selected='selected' value='TOT'>Total</option>";
								}else{
									print "<option value='TOT'>Total</option>";
								}			
							}else{
								print "<option>No Projects</option>";
							}				
					  	}else{
							if($project){
								foreach($project as $p){
						  			print "<option value=".$p['areaId'].">".$p['areaName']."</option>";
						  		}
						  		print "<option value='TOT'>Total</option>";
					  		}else{
					  			print "<option>No Projects</option>";
					  		}
					  	}					  	
					  	
					  ?>
					</select>
				</td>				
				<td>
					<input id="start-date" name="start-date" 
					value="<?php if(isset($_POST['flag'])){
						print $_POST['start-date'];
					}else print $date;?>" />
				</td>
				<td>
					<input id="end-date" name="end-date" 
					value="<?php if(isset($_POST['flag'])){
						print $_POST['end-date'];
					} else print $date;?>"  />
				</td>
			</tr>
		</table>
		<input type="hidden" name="flag" value="1" />
		<div id="submitBut">Generate Report</div>
	</form>
	</div>
	<hr/>

	<div id="detailArea">
		<?php 
		if(isset($_POST['flag'])){
			new ReportGenerator($_POST);
		}
		
		?>
	</div>
	<?php 
		if(isset($_POST['flag'])){
			print '<div id="printBut">Print Report</div>';
		}
	
	?>	
</div>
<div id="printDiv" style="display: none;" ></div>
