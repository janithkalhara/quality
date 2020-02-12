<?php
session_start();
require_once '../../../includes/HDatabase.php';
require_once '../../../libraries/base/project/lib_project.php';
require_once '../../../includes/Logger.php';

$error=false;
if(isset($_POST)){
	$flag=$_POST['flag'];

	if($flag=='deleteFromCrop'){
		deleteFromCrop($_POST);

	}

}

function deleteFromCrop($post){
	$data=$_POST['data'];
	$project=$data['project'];
	$vehicleNo=$data['vehicleNo'];
	$date=$data['date'];
	$log=new Logger("../../../logfile.log");

	$DBO=new HDatabase();
	$DBO->connect();

	if($DBO->delete('qa_stock',"id='$project' AND vehicleNo='$vehicleNo' AND date='$date'")){
		$error=false;
		 
	}else $error=true;
	//qa_gradeStock deleting
	if($DBO->delete('qa_gradeStock',"id='$project' AND vehicleNo='$vehicleNo' AND date='$date'  ")){
		$error=false;
		 
	}else $error=true;

	if($DBO->delete('qa_sample',"id='$project' AND vehicleNo='$vehicleNo' AND date='$date'  ")){
		$error=false;

	}else $error=true;

	//qa_center_fakes
	if($DBO->delete('qa_center_fakes',"id='$project' AND vehicleNo='$vehicleNo' AND date='$date' ")){
		$error=false;

	}else $error=true;
	//qa_stockImages
	if($DBO->delete('qa_stockImages',"id='$project' AND vehicleNo='$vehicleNo' AND date='$date' ")){
		$error=false;

	}else $error=true;
	//qa_stockUpdates
	$p=new Project();
	$pid=$p->getProjectIdByName($project);
 	$pnames=$p->getProjectNameById($project);
	if($DBO->delete('qa_stockUpdates',"areaId='".$project."'  AND vehicleNo='$vehicleNo' AND date='$date' ")){

		$error=false;
	}else $error=true;
	if($DBO->delete('qa_centerQuantity',"id='$project' AND vehicleNo='$vehicleNo' AND date='$date' ")){

		$error=false;
	}else $error=true;
	if($DBO->delete('qa_confirmed_stocks',"id='$project' AND vehicleNo='$vehicleNo' AND date='$date' ")){

		$error=false;
	}else $error=true;
	
	if(!$error){

		print '1';
		$logString="User :' ".$_SESSION['SESS_MEMBER_ID']." ' deleted data(Large/Medium grade). of project :' ".$pnames['areaName']." ' with Vehicle number :' ".$vehicleNo." ' in date :' ".$date." ' . Succeeded";
		$log->log(date('Y-m-d h:i:s'), $logString);

	}else{
		print '0';
		$logString="User :' ".$_SESSION['SESS_MEMBER_ID']." ' tried to delete data(Large/Medium grade). of project :' ".$pnames['areaName']." ' with Vehicle number :' ".$vehicleNo." ' in date :' ".$date." ' . But unsucceeded";
		$log->log(date('Y-m-d h:i:s'), $logString);
	}
	 
}
//232	232.00	2012-07-03 08:27:00	
?>