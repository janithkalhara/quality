<?php
require_once '../../../includes/HDatabase.php';
if(isset($_POST['flag'])){
	$flag = $_POST['flag'];

	if($flag == "getWeekCropData"){
		getWeekCropData($_POST);
	}
}

function getWeekCropData($post) {
	$season = $post['seasonId'];
	$grade = $post['gradeName'];
	$db = HDatabase::getInstance();
	$db->select("qa_ap_gradeWeekPercentages","weekNo,percentage","seasonId='$season' AND gradeName='$grade'","weekNo");
	$res = $db->getResult();
	echo json_encode($res);
}
?>