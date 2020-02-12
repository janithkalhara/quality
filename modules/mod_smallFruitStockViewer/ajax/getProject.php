<?php
require_once '../../../includes/HDatabase.php';

if(isset($_POST['season'])){
	$season = $_POST['season'];
	$con = new HDatabase();
	$con->connect();
	$con->select('qa_area qa,qa_gradeCategory qc','areaId,areaName',"season='$season' AND qa.cate_id=qc.id AND (qc.name='Small' OR qc.name='small') ","areaName");
	$result = $con->getResult();
	header('Content-type:application/json');
	if($result){
		echo json_encode(array('success'=>true,'data'=>$result));
	}
	else{
		echo json_encode(array('success'=>false));
	}
	
}



?>