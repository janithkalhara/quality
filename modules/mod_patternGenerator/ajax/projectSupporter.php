<?php
session_start();
require_once '../../../includes/HDatabase.php';

if(isset($_SESSION['SESS_MEMBER_ID'])) {
	if(isset($_POST['flag'])) {
		$flag = $_POST['flag'];
		if($flag = "getproject") {
			$season = $_POST['season'];
			Supporter::getProjectsBySeason($season);
		}
	}
	
}
else{
	exit();
}

class Supporter{
	
	public static function getProjectsBySeason($id){
		$db = HDatabase::getInstance();
		$db->select("qa_area","*","season='$id'");
		$res = $db->getResult();
		
		if($res) {
			$str = "<option value='-1'>Select a project</option>";
			foreach ($res as $temp){
				$str .= "<option value='".$temp['areaId']."'>".$temp['areaName']."</option>";
			}
			echo $str;
		}
		else {
			echo '<option value="-1">Select a project</option>';
		}
	}
}
?>