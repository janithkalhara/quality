<?php
class PatternHandler{
    
    function getCalculation($arrivals,$scheme,$ypa) {
        $result = array();
        for($i=0;$i<(count($arrivals)+count($scheme)-1);$i++ ) {
            $result[$i] = 0;
            for($j=(count($scheme)-1);$j>=0;$j--) {
                
            	if(isset($arrivals[$i-$j])) {
                   $result[$i] += ($arrivals[$i-$j]*$ypa*$scheme[$j])/100;
                }
            }  
        }
        return $result;
    }

    public function getScheme($project,$season){
    	$db = HDatabase::getInstance();
    	$db->select("qa_area","cate_id","areaId='$project'");
    	$res = $db->getResult();
    	$cate = $res[0]['cate_id'];
    	
    	$db->resetResult();
    	$scheme = array();
    	$db->select("qa_ap_gradeWeekPercentages","weekNo,percentage","seasonId='$season' AND cate_id='$cate'","weekNo ASC");
    	$res = null;
    	$res = $db->getResult();
    	$i = 0;
    	foreach ($res as $temp){
    		$scheme[$i]=$temp['percentage'];
    		$i++;
    	}
    	$db->disconnect();
    	
    	return $scheme;
    }
    
    public  function getYPA($project,$season){
    	
    	$db=new HDatabase();
    	$db->connect();
    	$db->select("qa_ap_ypaValues","*","projectId='$project' AND seasonId='$season'");
    	$res=$db->getResult();
    	return $res[0]['ypa'];
    	
    }
    
    public function getGradeWiseCalculation($project,$season,$graphValues) {
    	$weekShares = $this->getWeekShares($project, $season);
    	error_log('week shares => '.json_encode($weekShares));
    	$weekGradeValues = array();
    	$grades = array();
    	
    	for ($i=0;$i<count($graphValues);$i++){
    		$weekGradeValues[$i] = array(count($weekShares));
    		for($j=0;$j<count($weekShares);$j++){
    			$weekGradeValues[$i][$j] = round(($graphValues[$i]*$weekShares[$j]['share'])/100,2);
    			$grades[$i][$j] = $weekShares[$j]['gradeId'];
    		}
    	}
    	return array($weekGradeValues,$grades);
    }

    private function getWeekShares($project,$season){
    	error_log(__METHOD__.' => '.$project);
    	$db = HDatabase::getInstance();
    	$db->select("qa_area","cate_id","areaId='$project'");
    	$res = $db->getResult();
    	$grade = $res[0]['cate_id'];
    	$db->resetResult();
    	$db->select("qa_ap_GradeShare gs, qa_gradeCategory c, qa_grade g","gs.gradeId,gs.share",
    		"gs.gradeId = g.gradeId
			AND g.cate_id = c.id
			AND c.id ='$grade'");
    	$res2 = $db->getResult();
    	return $res2;
    }
}
?>    