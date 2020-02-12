<?php
require_once '../../../includes/HDatabase.php';

if(isset($_POST['seasonId'])){
	$seasonId = $_POST['seasonId'];
	
	$db = new HDatabase();
	$db->connect();
	$db->select("qa_area","areaId,areaName","season='$seasonId'",'areaName');
	$res = $db->getResult();
	
	$projects = "<option value='Total'>Select a Project</option>";
	
	foreach ($res as $r){
		$projects .= "<option value='".$r['areaId']."'>".$r['areaName']."</option>";
	}
	print $projects;
}

?>