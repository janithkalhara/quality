<?php 
global $import;
$import->importLib("season");

$import->importJS("arrivalPatterns","tableHelper");

$import->importClass('arrivalPatterns', 'TentManager');
?>
<div id="tentaive-wrapper">
<div id="selection-area">
<form action="home.php?option=mod_arrivalPatterns&section=tentativeReport" method="post">
	<table>
		<tr>
			<td>Select the Season: </td>
			<td>
				<select id="season-tentReport" name="season-tentReport"> 
				<option selected="selected" value="-1">Select Season</option>
				<?php 
				
				$season=new Season();
				$seasons=$season->getSeasons();
				foreach ($seasons as $t){
					print "<option value='".$t['seasonId']."'>";
					print $t['seasonName'];
					print "</option>";
				}
				
				?>
				</select>
			</td>
			<td>
			  <input type="submit" class="button" value="Generate Report">
			  <input type="hidden" name="task" value="Generate-Report">
			</td>
		
		</tr>
	</table>
</form>

</div><div id="print-toobar-tentative" style="display:none" onclick="printReport()">
<p> Print the Report</p>
</div>
<div id="wrapper-tentReport" ">

<?php 
    if(isset($_POST['task'])){
    	$task=$_POST['task'];
    	$season=$_POST['season-tentReport'];
    	if($task=='Generate-Report'){
    		$manager=new TentManager($season);
    		$oldestWeek=$manager->getOldestWeek();
    		$firstWeek=$oldestWeek['leastweek'];
    		$numOfWeeks=$oldestWeek['numofweeks'];
    		$weekList=$manager->getWeekList($firstWeek, $numOfWeeks);
    		$headerArray1=array("Incharge","Project","Grade","Planned Acreage","Revised Acreage");
            $headerArray2=array("Total","Difference");
    		$middle=array_merge($headerArray1,$weekList);
    		$header=array_merge($middle,$headerArray2);
	    	$suppliers=Array();
	        $existingGrades=Array();
	        $suppliers=$manager->getSuppliers();
	        for($i=0;$i<count($suppliers);$i++){
	            $existingGrades[$i]=$suppliers[$i][3];
	        }
    		$ex_grades=array();
    		$existingGrades=array_unique($existingGrades);
    		$i=0;
    		foreach ($existingGrades as $temp){
    			$ex_grades[$i]=$temp;
    			$i++;
    		}
    		//project ids setting 
    		$gradeSuppliers=array();
    		for($i=0;$i<count($ex_grades);$i++ ){
                $gradeSuppliers[$i]=array();
	            for($j=0;$j<count($suppliers[$i]);$j++){
	                if($suppliers[$j][3]==$ex_grades[$i]){
	                    array_push($gradeSuppliers[$i], $suppliers[$j][0]);
	                }
	            }
	            
            }
            $plans=$manager->getProjectPlans($ex_grades, $suppliers);
           $manager->renderReport($header,$ex_grades,$plans);
    	}
    }
?>
</div>
</div>