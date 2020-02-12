<?php
require_once '../../../includes/HDatabase.php';

if($_POST['flag']=='first'){
	$seasonId = $_POST['seasonId'];
	$type = $_POST['type'];
		
	$db = new HDatabase();
	$db->connect();
	
	if($type != "TOT")
		$db->select("qa_area","areaId,areaName","season='$seasonId' AND areaType='$type'","areaName ASC");
	else
		$db->select("qa_area","areaId,areaName","season='$seasonId'","areaName ASC");
		
	$res = $db->getResult();	
	
	$result = "";
	
	if($res){
		foreach ($res as $r){
			$result .= "<option value=".$r['areaId'].">".$r['areaName']."</option>";
		}
		$result .= "<option value='TOT'>Total</option>";		
	}else{
			$result = "<option>No Projects</option>";
	}
	print json_encode($result);
}

?>