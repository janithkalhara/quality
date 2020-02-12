<?php
class Plan {
	
	public function  getPlans($project,$season) {
		$planId = $project."-".$season."-"."1";
		$db = HDatabase::getInstance();
		$db->select("qa_ap_acerValue","*","revisionId='$planId'","weekNumber");
		$result = $db->getResult();
		return $result;
	}
}

class Revisions {
	
	public function getRevisions($project,$season) {
		$revisions = $this->getExistingRevisions($project, $season);
	    $numOfRevisions = count($revisions);   
		$db = HDatabase::getInstance();
	    $revisionsAll = array();
	    //getting revisions seperately
	    for($i=0;$i<$numOfRevisions;$i++){
	    	$revisionNo = $revisions[$i]['weekCount'];
	    	$revisionId = $project.'-'.$season.'-'.$revisionNo;
	    	$db->resetResult();
	    	$db->select("qa_ap_acerValue","*","revisionId='$revisionId' AND weekCount='$revisionNo'","weekCount,weekNumber ASC");
	    	$revisionsAll[$i] = $db->getResult();
	    }

	    return $revisionsAll;
	}

	public function getExistingRevisions($project,$season){
		$db = HDatabase::getInstance();
		$db->select("qa_ap_revision","*","projectId='$project' AND seasonId='$season'","weekCount ASC");
		$res = $db->getResult();
		return $res;
	}
}
?>