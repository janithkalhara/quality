<?php
require_once '../../../includes/HDatabase.php';

if (isset($_POST)){
	$flag = $_POST['flag'];
	if($flag == "getlatestPlanOrRevision"){
		RevisionDataManager::getlatestPlanOrRevision($_POST);
	}
}

class RevisionDataManager{
	
	public static function getlatestPlanOrRevision($post){
		$project = $post['project'];
		$season = $post['season'];
		$db = HDatabase::getInstance();
		$latestRevision = array();
		$db->select("qa_ap_revision","*","projectId='$project' AND seasonId='$season'","weekCount DESC");
		$res1 = $db->getResult();

		 if($res1 != null) {
		 	$latestRevision['flag'] = 'revision';
		 	$latestRevision['values'] = self::getRevision($res1[0]['revisionId'],$res1[0]['weekCount']); 
		 }
		 else if($res1 == null) {
		 	$db->resetResult();
		 	$db->select("qa_ap_seedingPlan","*","projectId='$project' AND seasonId='$season'","weekCount DESC");
		 	$res2 = $db->getResult();

		 	if($res2 != null){
		 		$latestRevision['flag'] = "plan";
		 		$latestRevision['values'] = self::getPlan($res2[0]['planId']);
		 	}
		 	else { 
		 		$latestRevision=null;
		 	}
		 }
		echo json_encode($latestRevision);
	}
	
	public static function getPlan($planId){
		
		$planData = array();
		$planData['planId'] = $planId;
		$planData['weekCount'] = 1;
	  	$planData['planValues'] = array();
		$planData['weeks'] = array();
		
		$db = HDatabase::getInstance();
		$db->select("qa_ap_acerValue","*","revisionId='$planId' AND  weekCount='1'","weekNumber ASC");
		$res = $db->getResult();
		
		if(isset($res)) {
			$i=0;
			foreach ($res as $temp){
				$planData['planValues'][$i] = $temp['noOfAcers'];
				$planData['weeks'][$i] = $temp['week'];
				$planData['seeded'][$i] = $temp['seeded'];
				$i++;
			}
			return $planData;
		}
		return null;
	}
	
	public static function getRevision($id,$weekCount) {
		$revData = array();
        $revData['revisionId'] = $id;
        $revData['weekCount'] = $weekCount;
        $revData['revisionValues'] = array();
        $revData['weeks'] = array();
        $revData['restArray'] = self::getRestWeeks($id, $weekCount);
        
        $db = HDatabase::getInstance();
        $db->select("qa_ap_acerValue","*","revisionId='$id' AND  weekCount='$weekCount'","weekNumber ASC");
        $res = $db->getResult();
       
        if(isset($res)) {
            $i = 0;
            foreach ($res as $temp) {
                $revData['revisionValues'][$i] = $temp['noOfAcers'];
                $revData['weeks'][$i] = $temp['week'];
                $revData['seeded'][$i] = $temp['seeded'];
                $i++;
            }
            return $revData;
        }
        return null;
	}
	
	public static function getRestWeeks($planId,$largest) {
		$db = HDatabase::getInstance();
		$restArray = array();
		$remainArray = array(0);
		$splitted = explode('-',$planId);
		$tempId = $splitted[0]."-".$splitted[1];
		$db->resetResult();
        $db->select("qa_ap_acerValue",'DISTINCT weekCount',"revisionId  like '".$tempId."%'","weekCount ASC");
        $res = $db->getResult();
        $k = 0;
		foreach ($res as $temp) {
			$restArray[$k] = $temp['weekCount'];
			$k++;
		}
        
        for($i=1;$i<=$largest;$i++) {
			//$key=array_search($i,$restArray);
			if(in_array($i, $restArray)) {
			}
			else{
				array_push($remainArray,$i);
			}
		}
		return $remainArray;
	}
}
?>