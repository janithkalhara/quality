<?php 
global $import;
$import->importLib("season");
$import->importLib("grade");
$import->importClass("arrivalPatterns", "ForecastManagerBig");
$import->importJS("arrivalPatterns", "forecastHelper");
?>
<script type="text/javascript">
function checkSeason(){
	var val=$('#season-patternWrapper').val();
	var grade=$('#grade-patternWrapper').val();
	if(val==-1){
	    alert('Please select the season');
	    return false;
	}else if(grade==-1){
		alert('Please select the grade');
        return false;
	}
	else return true;
}
</script>
<div id="patternWrapper">
	<form action="home.php?option=mod_arrivalPatterns&section=forecastPattern" onsubmit="return checkSeason()" method="post" >
		<select name="season-patternWrapper" id="season-patternWrapper">
			<option value="-1">Select the season</option>
			<?php $s=new Season();
				$seasons = $s->getSeasons();
				foreach ($seasons as $temp){
					print "<option value='".$temp["seasonId"]."'>".$temp["seasonName"];
					print "</option>";
				}
			?>
		</select>
		<select id="grade-patternWrapper" name="grade-patternWrapper">
			<option value="-1">Select the grade</option>
			<?php 
				$g = new Grade();
				$cates = $g->getGradeCategories();
				foreach ($cates as $temp){
					print "<option value='".$temp["id"]."'>".$temp["name"];
    				print "</option>";
				}
?>
		</select>
		<input type="submit" value="Generate Report" class="button">
		<input type="hidden" name="task" value="Generate-forecast-Report">
	</form>
	<div id="print-toobar-forecast" style="" onclick="printReport()">
		<p>Print the Report</p>
	</div>
<?php 
if(isset($_POST['task'])){
	$task = $_POST['task'];
	if($task == "Generate-forecast-Report"){
		$season = $_POST['season-patternWrapper'];
		$grade = $_POST['grade-patternWrapper'];
		error_log($grade);
		$manager = new ForecastManager($season,$grade);
		$manager->setInExProjects();
		$manager->setWeekList();
		$manager->setInternalGradeWeekQuantities();
		$manager->setExternalGradeWeekQuantities();
		$manager->renderDataTable();
	}
}
?>
</div>