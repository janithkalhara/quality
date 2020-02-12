<?php 
global $import;
$import->importLib("season");
$import->importLib("grade");
$import->importClass("arrivalPatterns", "ForecastPatternTotal");
$import->importJS("arrivalPatterns", "forecasttotal");
?>
<div id="forecast-total-wrapper">
	<div id="patternWrapper">
		<form action="home.php?option=mod_arrivalPatterns&section=forecastPatterntotal" onsubmit="return checkSeason()" method="post" >
			<select name="season-patternWrapper" id="season-patternWrapper">
				<option value="-1">Select the season</option>
				<?php 
				$s=new Season();
				$seasons=$s->getSeasons();
				foreach ($seasons as $temp){
	    			print "<option value='".$temp["seasonId"]."'>".$temp["seasonName"];
	    			print "</option>";
				}
				?>
			</select>
			<input type="submit" value="Generate Report" class="button">
			<input type="hidden" name="task" value="Generate-forecast-Report-total">
		</form>
		<div id="print-toobar-forecasttotal" style="" onclick="printReport()">
		<p> Print the Report</p>
		</div> 
		<div id="print-forecasttotal" style="margin-top:35px">
		<?php 
			if(isset($_POST['task'])){
			    $task=$_POST['task'];
			    if($task=="Generate-forecast-Report-total"){
			    	$season=$_POST['season-patternWrapper'];
			    	$manager=new TotalManager($season);
			    	$manager->setSubGrades();
			    	$manager->setWeekList();
			    	$manager->setWeekGradewiseQuantities();
			    	$manager->renderReport();
			    }
			}
		?>	
		</div>
	</div>
</div>