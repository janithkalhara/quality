<?php

require_once '../../includes/HDatabase.php';
require_once '../../includes/HFactory.php';
require_once '../../libraries/base/season/lib_season.php';

$project = $_POST['project'];
header('Content-type:application/json');

$do = $_POST['do'];
switch($do){
	
	case 'getProject':
		doGetProjects($project);
		break;
	case 'getCenter':
		$center = $_POST['center'];
		$flag = $_POST['target'];
		doGetCenters($center, $project,$flag);
		break;
	default:
}

function doGetProjects($project){
	$season = Season::getSeason();
	$db = HFactory::getDb();
	$db->select('qa_area','areaId,areaName',"areaName LIKE '{$project}%' AND cate_id='5' AND season='{$season['seasonId']}'");
	$result = $db->getResult();
	
	if($result){
		$html = '';
		foreach ($result as $r){
			$areaName = $r['areaName'];
			$area=$r['areaId'];
			$html .='<li class="suglist" onclick="showAlert(this.id,\''.$areaName.'\')" id="'.$area.'">'.$r['areaName'].'</li>';
		}
		
		echo json_encode(array('success'=>true,'data'=>array('html'=>$html)));
	}
	else{
		echo json_encode(array('success'=>false,'message'=>'No Projects'));

	}
}

function doGetCenters($center,$project,$flag){
	$season = Season::getSeason();
	$db = HFactory::getDb();
	$db->select('qa_center','centerName,centerId',"centerName LIKE '$center%' AND areaId='$project'");
	$result = $db->getResult();
	if($result){
		$html = '';
		foreach($result as $r2){
			$centerName = $r2['centerName'];
			$centerId = $r2['centerId'];
			$html .= '<li class="sugCenterlist" id="'.$centerName.'" onclick="addCenter(this.id,'.$flag.')" >'.$centerName.'</li>';
				
		}
		echo json_encode(array('success'=>true,'data'=>array('html'=>$html)));
	}
	else{
		echo json_encode(array('success'=>false,'message'=>'No Centers'));
	}
	
}


?>