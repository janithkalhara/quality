<?php

require_once '../../../includes/HDatabase.php';

if(isset($_POST['flag'])){
	$flag = $_POST['flag'];
	if($flag == "getGradeByCate"){
		$cate = $_POST['cate'];
		print json_encode(RateShareManager::getGradesByCategory($cate));
	}
}

class RateShareManager{
	public static function getGradesByCategory($cate){
        $db = HDatabase::getInstance();
		$db->select("qa_grade","*","cate_id='$cate'");
		$res = $db->getResult();
		return $res;
	}
	
}
?>