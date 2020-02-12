<?php
require_once '../../../includes/HDatabase.php';
if(isset($_POST)){
	$project = $_POST['project'];
	$season = $_POST['season'];
	$rates = Rates::getRatesById($project,$season);
	print json_encode($rates);
	
}


class Rates{
	public static function getRatesById($pId,$sid){
		$db = HDatabase::getInstance();
		$db->select("qa_ap_ypaValues","*","projectId='$pId' AND seasonId='$sid'");
		$res = $db->getResult();
		return $res[0];
	}
}
?>