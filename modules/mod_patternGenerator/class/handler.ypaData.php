<?php

global $import;
$import->importLib("grade");

class handlerYPAData{
	
	public function processData($post){
		
	       $project=$post['project-ratesdata'];
		   $yield=$post['yield-ratesdata'];
		  $season=$post['season-ratesdata'];
		   $db=new HDatabase();
		   $db->connect();
		   global $mainframe;
		   if($db->insert("qa_ap_ypaValues", array($project,$season,$yield))){
		   	  $mainframe->putMessage("Data saved Successfully",HIGHLIGHT);
		   	
		  }else{
		  	   $mainframe->putMessage("There was an error saving data .Please try again later !",ERROR);
		  }
		   
	}
	
	public function updateData($post){
		
		$project=$post['project-edit-YPAratedata'];
        $season=$post['season-edit-ratesdata'];
		
		global $mainframe;
		$db=new HDatabase();
        $db->connect();
		
		$ypa=$post['ypa-edit-ratesdata'];

		if($db->update("qa_ap_ypaValues", "ypa='$ypa'", "projectId='$project' AND seasonId='$season'")){
			$mainframe->putMessage("Data Updated Successfully!", HIGHLIGHT);
		}else{
			$mainframe->putMessage("There was an error occured in updating data", ERROR);
		}
		
		
	}
	
}

class handlerCropShareData{
	
	public function saveGradeShareData($post){
		
		 $db=new HDatabase();
		 $db->connect();
		 global $mainframe;
		 $error=false;
		
		 $cate=$post['crop-cropgraderate'];
		 $grades=new Grade();
		 $grade_name=$grades->getGradeCategoryNameById($cate);
		 
		 
		 
		 $numberOfGrades=$post['numberOfGrades'];
		 for($i=0;$i<$numberOfGrades;$i++){
		 	//grade-rates-0
		 	$share=$post['grade-rates-'.$i];
		 	$grade=$post['grade-rates-hidden-'.$i];
		 	$fc=$post['grade-rates-fc-'.$i];
		 	if($db->insert("qa_ap_GradeShare",array($grade,$share,$grade_name['name'],$fc))){
			 $error=false;
			
		      }else{
		      	
		      	$error=true;
		      }
		 	
		 }
		 
		 
		 
		 
		 if(!$error){
		 	$mainframe->putMessage("Data Saved Successfully!",HIGHLIGHT);
		 }
	      else{
			$mainframe->putMessage("There was an error saving data.Please try again later.", ERROR);
			
		}
		$db->disconnect();
	} 
	
	public function updateShareData($post){
	$numberOfGrades=$post['update-numberOfGrades'];
	$cate=$post['view-crop-cropgraderate'];
	$error=false;
	    $db=new HDatabase();
         $db->connect();   
	   global $mainframe;
	   
	   	
	   	$db->delete("qa_ap_GradeShare","gradeCategory='$cate'");
	   	
	   
	
         for($i=0;$i<$numberOfGrades;$i++){
            //grade-rates-0
            $share=$post['grade-rates-'.$i];
            $grade=$post['grade-rates-hidden-'.$i];
            $fc=$post['grade-rates-fc-'.$i];
            
          if($db->insert("qa_ap_GradeShare",array($grade,$share,$cate,$fc))){
             $error=false;
            
              }else{
                
                $error=true;
              }
            
         }
	     
         if(!$error){
            $mainframe->putMessage("Data Updated Successfully!",HIGHLIGHT);
         }
          else{
            $mainframe->putMessage("There was an error saving data.Please try again later.", ERROR);
            
        }
        $db->disconnect();
        
	}
	
}


class handlerCropWeekData{
	
	
	public function insertWeekCropData($post){
		
		$gradeCate=$post['gradeCategory-weeks'];
		$numWeeks=$post['number_weeks'];
		$season=$post['season-weeks'];
		$grades=new Grade();
		$grade=$grades->getGradeCategoryNameById($gradeCate);
		$percentage=array();		
		$error=false;
		for($i=0;$i<$numWeeks;$i++){
			$percentage[$i]=$post['crop-per-week-'.$i];
			
		}
	
		$db=new HDatabase();
		$db->connect();
		for($i=0;$i<$numWeeks;$i++){
			if($db->insert("qa_ap_gradeWeekPercentages", array($season,$gradeCate,$grade['name'],($i+1),$percentage[$i]))){
				$error=false;
			}else{
				//	print $db->getError();
				$error=true;
			}
				
			
					
		}
		global $mainframe;
		
	if($error==false){
		$mainframe->putMessage("Data updated successfully.",HIGHLIGHT);
	}else{
		$mainframe->putMessage("There was an error saving data.Please try again later.",ERROR);
	}
		  	
		
		
		
	}
	
	public function updateWeekCropData($post){
		
		$gradeCate=$post['gradeCategory-weeks'];
        $numWeeks=$post['number_weeks'];
        $season=$post['season-weeks'];
        $percentage=array();      
        $grades=new Grade();
		$grade=$grades->getGradeCategoryNameById($gradeCate);  
        $error=false;
        for($i=0;$i<$numWeeks;$i++){
            $percentage[$i]=$post['crop-per-week-'.$i];
            
        }
        $db=new HDatabase();
        $db->connect();
        /*dalete previous data*/
        
        $db->delete("qa_ap_gradeWeekPercentages","seasonId='$season' AND cate_id='$gradeCate'");
        
        print "grade cate";
        var_dump($post);
        for($i=0;$i<$numWeeks;$i++){
            if($db->insert("qa_ap_gradeWeekPercentages", array($season,$gradeCate,$grade['name'],($i+1),$percentage[$i]))){
                $error=false;
            }else{
            	print $db->getError();
                $error=true;
            }
                
            
                    
        }
        global $mainframe;
        
    if($error==false){
        $mainframe->putMessage("Data updated successfully.",HIGHLIGHT);
    }else{
        $mainframe->putMessage("There was an error saving data.Please try again later.",ERROR);
    }
        
		
		
	}
	function  removeWeekCropData($season,$grade){
		$db=new HDatabase();
		$db->connect();
		global $mainframe;
		if($db->delete("qa_ap_gradeWeekPercentages","seasonId='$season' AND gradeName='$grade'")){
			//self::callRefresh();
			$mainframe->putMessage("Week data removed Successfully!", HIGHLIGHT);
			//sleep(1);
			 print '<META HTTP-EQUIV="Refresh" Content="0; URL=home.php?option=mod_patternGenerator">';    
             
			
			exit;
		}else{
			$mainframe->putMessage("There was an error deleting data.", ERROR);
		}
	}
	

		
	
}




?>