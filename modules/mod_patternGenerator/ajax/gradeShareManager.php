<?php
require_once '../../../includes/HDatabase.php';

if(isset($_POST)) {
	$flag = $_POST['flag'];
	if($flag == "getSharesByGrade"){
		getSharesByGrade($_POST['cateId']);
	}
}

function getSharesByGrade($cate) {
	$db = HDatabase::getInstance();
	$db->select("qa_grade","gradeId,fruitCount","cate_id='$cate'");
	$res = $db->getResult();
	
	if($res) {
		$subgrade_shares = array();
		$i = 0;
		foreach ($res as $temp) {
			$db->resetResult();
			$db->select("qa_ap_GradeShare gs,qa_grade g","*","gs.gradeId='".$temp['gradeId']."'");
			$res2 = $db->getResult();
			$subgrade_shares[$i]['share'] = $res2[0]['share'];
			$subgrade_shares[$i]['subgradeId'] = $temp['gradeId'];
			$subgrade_shares[$i]['fc'] = $temp['fruitCount'];
			$i++;
		}
		print json_encode($subgrade_shares);
		
	}
	else {
		echo json_encode(false);
	}
	
}
?>