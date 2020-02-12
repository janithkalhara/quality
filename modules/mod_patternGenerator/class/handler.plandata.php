<?php
define('WEEK_COUNT', 1);
class handlerPlanData{
	
	public static function processPlanData($post) {
	    $project = $post['project-plandata'];
	    $season = $post['season-plandata'];
	    $startDate = $post['startDate-plandata'];
	    $numOfWeeks = $post['numofweeks-plandata'];
	    $db = HDatabase::getInstance();
	    
	    $weeks = array();
	    for($i=0;$i<$numOfWeeks;$i++) {
	        $weeks[$i]['acer'] = $post['input-'.$i];
	        $weeks[$i]['week'] = $post['hidden-input-'.$i];
	         $weeks[$i]['seeded'] = $post['seededFlag-plandata-'.$i];
	    }
	    $error = false;
	    $planId = $project."-".$season."-".WEEK_COUNT;
	    try {
	    	if($db->insert("qa_ap_seedingPlan", array($planId,$project,$season,WEEK_COUNT))) {
	    		$error = false;
	    	}
	    	else {
	    		$error = true;
	    	}
	        
	        for($i=0;$i<$numOfWeeks;$i++) {
                if($db->insert("qa_ap_acerValue", array($planId,WEEK_COUNT,$weeks[$i]['week'],$i,$weeks[$i]['acer'],$weeks[$i]['seeded']))){
                	$error = false;
                }
                else {
                	$error = true;
                }
	        }

	        global $mainframe;
	        
	        if(!$error) {
		        $mainframe->putMessage("Plan data saved Successfully!",HIGHLIGHT);
		        $dataArray['planId']=$planId;
		        $dataArray['project']=$project;
		        $dataArray['season']=$season;
		        $dataArray['startDate']=$startDate;
		        $dataArray['numOfWeeks']=$numOfWeeks;
		        $dataArray['weeks']=$weeks;
		        self::printSubmittedData($dataArray);
	        }else{
	        	$mainframe->putMessage("There was an Error Saving Data.Please Try again !", ERROR);
	        }
	    }
	    catch (Exception $e) {
	        print $e->getMessage();
	    }
	    
	}

	public static function printSubmittedData($dataArray){
	 	$project = new Project();
	 	$projectName = $project->getProjectNameById($dataArray['project']);
	 	$season = new Season();
	 	$seasonName = $season->getSeasonNameById($dataArray['season']);
	 	$weeks = $dataArray['weeks'];
	 	?>
	 	<div id="controls-plandata-editable" >
	 	<a  onclick="setEditableFields()" ><span class="hui-edit"></span>Edit</a>
	 	<a href="home.php?option=mod_patternGenerator" ><span class="hui-next"></span>Continue</a>
	 	</div>
	 	<fieldset>
	 	<legend><strong>Saved plan Data </strong></legend>
	 	<table border="1" cellpadding="0" cellspacing="0" id="table-header-plandata-editable">
		  <tr>
		    <td><strong>Project</strong></td>
		    <td align="center"><?php print $projectName['areaName']?></td>
		    <td><strong>Season</strong></td>
            <td align="center"><?php print $seasonName?></td>
		  </tr> <tr>
		    <td><strong>Start date</strong></td>
		    <td align="center"><?php print $dataArray['startDate']?></td>
		    <td ><strong>Number of Weeks</strong></td>
            <td align="center"><?php print $dataArray['numOfWeeks']?></td>
		  </tr>
        </table>
        <table border="1" cellpadding="0" cellspacing="0" id="table-header-plandata-editable-weeks" >
        <tr>
        <?php 
        for ($i=0;$i<$dataArray['numOfWeeks'];$i++){
        	print "<td align='center'>";
        	$e = explode("/",$weeks[$i]['week'] );
        	$year = $e[2];
        	$dateDiffer = $e[0]."/".$e[1];
        	print "<strong>".$dateDiffer."</strong>";
        	print "<p>".$year."</p>";
        	print "</td>";
        }
        ?>
        </tr>
        <tr>
        <tr>
        <?php 
        for ($i=0;$i<$dataArray['numOfWeeks'];$i++) {
            print "<td align='center'>";
            print $weeks[$i]['acer'];
            print "<select name='seededFlag-plandata-$i' name='seededFlag-plandata-$i' disabled='disabled'>";
            if( $weeks[$i]['seeded']==0){
            	print "<option selected='selected' value='0'>p</option>";
            	print "<option value='1'>s</option>";
            }else{
            	print "<option value='0'>p</option>";
                print "<option selected='selected'value='1'>s</option>";
            	
            }
            print "</select>";
            print "</td>";
        }
        print "<input type='hidden' name='weekdata' id='hidden-edit-weekdata' value='".json_encode($weeks)."'/> ";
        ?>
        </tr>
        </table>
        </fieldset>
	<script type="text/javascript">
		function setEditableFields() {
		$('#project-plandata').val('<?php print	$dataArray['project']?>'); 
		$('#season-plandata').val('<?php	print $dataArray['season']?>');
		$('#startDate-plandata').val('<?php print $dataArray['startDate']?>');
		$('#numofweeks-plandata').val('<?php print $dataArray['numOfWeeks']?>');

		setDataTable('<?php print $dataArray['numOfWeeks']?>'); 
		var	weeksArray=jQuery.parseJSON($('#hidden-edit-weekdata').val());
		
		for(var i=0; i<weeksArray.length;i++){
			
			  $('#input-'+i).val(weeksArray[i]['acer']);
			  $('#seededFlag-plandata-'+i).val(weeksArray[i]['seeded']);
		} 

		$('#task').val("edit_plan_data"); 
		$('#tracker').val('<?php print $dataArray['planId']?>');
		}
		</script>
        <?php 
		}
		function updatePlanData($data) {
			$tracker = $data['tracker'];
			$db = HDatabase::getInstance();
			$splitted = explode('-', $tracker);
			global $mainframe;
		 	/*Deleting*/
			try{
			 	$db->delete("qa_ap_acerValue","revisionId='$tracker' AND weekCount='1'");
		        $db->delete("qa_ap_seedingPlan","planId='$tracker' AND weekCount='1'");
		        $db->delete("qa_ap_week","revisionId='$tracker'");
			}
			catch (Exception $e) {
		
			}
		 	
			try {
			 	$project = $data['project-plandata'];
		        $season = $data['season-plandata'];
		        $startDate = $data['startDate-plandata'];
		        $numOfWeeks = $data['numofweeks-plandata'];
		        
			   	$weeks = array();
		        for($i=0;$i<$numOfWeeks;$i++){
		            $weeks[$i]['acer'] = $data['input-'.$i];
		            $weeks[$i]['week'] = $data['hidden-input-'.$i];
		            $weeks[$i]['seeded'] = $data['seededFlag-plandata-'.$i];
		        }
		        $planId = $project."-".$season."-".WEEK_COUNT;
		        
		        try {
		        	$db->insert("qa_ap_seedingPlan", array($planId,$project,$season,WEEK_COUNT));
		            for($i=0;$i<$numOfWeeks;$i++){
		                //inserting acer values
		                $db->insert("qa_ap_acerValue", array($planId,WEEK_COUNT,$weeks[$i]['week'],$i,$weeks[$i]['acer'],$weeks[$i]['seeded']));
		                $week = self::getWeekSeperate($weeks[$i]['week']);
		                $mainframe->putMessage("Plan Data updated Successfully!",HIGHLIGHT);
		            }
		            
		        }
		        catch (Exception $e) { }
		        
			 }
			 catch (Exception $e) { }
		}
	 
		function getWeekSeperate($weekString) {
		 	$a = explode("/",$weekString);
		 	$year = $a[2];
		 	$month = $a[1];
		 	$split_dates = explode("-",$a[0]);
		 	$start = $split_dates[0];
		 	$end = $split_dates[1];
		 	$weeks = array();
		 	$weeks['start'] = $year."-".$month."-".$start;
		 	$weeks['end'] = $year."-".$month."-".$end;
		 	return $weeks;
		}
		 
		function clearAll($post) {
		}
	 
		public static function checkDependencies($post){
	 	$db =  HDatabase::getInstance();
		$project = $post['project-plandata'];
	    $season = $post['season-plandata'];
	    $startDate = $post['startDate-plandata'];
	    $numOfWeeks = $post['numofweeks-plandata'];
	    $error = array();
	    $error['error'] = false;
		/*
		 * necessary fields
		 * ypa value,gradeshare,qa_ap_gradeWeekPercentages,
		 */
	    //checking YPA value
		$db->resetResult();
	    $db->select("qa_ap_ypaValues","*","projectId='$project' AND seasonId='$season'");
	    $res = $db->getResult();
	   
	    if(!$res) {
	    	$error['error'] = true;
	    	$error['type'] = "ypa";
	    }
	    $db->resetResult();
	    $db->select("qa_area a, qa_gradeCategory c, qa_grade g, qa_ap_GradeShare gs","*",
	    		"a.areaId='$project' AND 
	    		a.cate_id=c.id AND 
	    		c.id=g.cate_id AND 
	    		g.gradeId = gs.gradeId
	    		");
	    $res = null;
	    $res = $db->getResult();
	    if($res){ }
	    else {
	    	$error['error'] = true;
	    	$error['type'] = 'gradeShare';
	    }
	    //checking  gradeWeek % s .
	    $db->resetResult();
	    $db->select("qa_area a, qa_ap_gradeWeekPercentages gs","*",
	    		"a.areaId='$project' AND 
	    		a.cate_id=gs.cate_id	    		
	    		");
	    $res = null;
	    $res = $db->getResult();
	    if($res) {
	    	
	    }
	    else {
	    	$error['error'] = true;
	    	$error['type'] = 'gradeWeek';
	    }
	    return $error;
	    
	 }
}
?>