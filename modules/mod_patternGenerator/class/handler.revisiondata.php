<?php
class revisionDataHandler{
	
	public static function saveRevisionData($post){
		$project = $post['project-revisiondata'];
		$season = $post['season-revisiondata'];
		$revisionSelector = $post['revision-selector'];
		$numOfWeeks = $post['numOfweeks-hidden'];
		$revNumber;

		if(isset($revisionSelector)) {
			
			if($revisionSelector == -1) {
	            $revNumber = $post['revision-number-selector'];
	            $revisionId = $project."-".$season."-".$post['revision-number-selector'];
	        }
	        else if($post['revision-number-selector'] == '') {
	            $revNumber = $post['revision-selector'];
	            $revisionId = $project."-".$season."-".$post['revision-selector'];
	        }
		}
		$db = HDatabase::getInstance();
		$error = false;
		$db->insert("qa_ap_revision",array($revisionId,$project,$season,$revNumber) );
		
		for($i=0;$i<$numOfWeeks;$i++){
			$weekValue = $post['revisionData-insert-'.$i];
			$week = $post['hidden-revisionData-insert-'.$i];
			$seeded = $post['seededFlag-plandata-'.$i];
			
			if($db->insert("qa_ap_acerValue",array($revisionId,$revNumber,$week,$i,$weekValue,$seeded))){
				$error = false;
			}
			else {
			  	$error=true;
			}
		}
		global $mainframe;
		
		if($error) {
			$mainframe->putMessage("There was an error in saving data.Please try again Later.", ERROR);
		}
		else {
			$mainframe->putMessage("Revision data saved successfully!.", HIGHLIGHT);
		}
	}
}
?>