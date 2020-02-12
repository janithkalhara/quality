<?php
session_start();
require_once '../../../includes/HDatabase.php';
require_once '../../../libraries/base/project/lib_project.php';
require_once '../../../includes/Logger.php';
$error = false;
if(isset($_POST)){
	$flag = $_POST['flag'];
	
	if($flag == 'deleteFromCrop'){
		deleteFromCrop($_POST);
	}
}


function deleteFromCrop($post) {
	$data=$_POST['data'];
	$project=$data['project'];
	$vehicleNo=$data['vehicleNo'];
	$date=$data['date'];
	$log=new Logger("../../../logfile.log");

    $DBO=new HDatabase();
    $DBO->connect();
    if($DBO->delete('qa_small_crop',"id='$project' and vehicleNo='$vehicleNo' AND date='$date'")) {
 	  	//$error = false;
   	}
   	else {
   		$error	= true;
   	}
    // qa_small_belongs
   	if($DBO->delete('qa_small_belongs',"id='$project' and vehicleNo='$vehicleNo' AND date='$date'  ")) {
	    //$error = false;
   	}
   	else {
   		$error = true;
   	}
	//qa_small_cropSampleGrades
    if($DBO->delete('qa_small_cropSampleGrades',"id='$project' and vehicleNo='$vehicleNo' AND date='$date'")) {
    	//$error = false;
   	}
   	else {
   		$error = true;
   	}
   	
   	if($DBO->delete('qa_small_cropSampleStat',"id='$project' and vehicleNo='$vehicleNo' AND date='$date'")) {
   		//$error = false;
   	}
   	else {
   		$error = true;
   	}
   // qa_small_crsData
    if($DBO->delete('qa_small_crsData',"id='$project' and vehicleNo='$vehicleNo' AND date='$date'")) {
    	//$error = false;
   	}
   	else {
   		$error = true;
   	}
   //qa_small_crsSampleData
   	if($DBO->delete('qa_small_crsSampleData',"id='$project' and vehicleNo='$vehicleNo' AND date='$date'")) {
    	$error = false;
   	}
   	else { 
   		$error = true;
   	}
   // qa_stockImagesSmall
    if($DBO->delete('qa_stockImagesSmall',"id='$project' and vehicleNo='$vehicleNo' AND date='$date'")) {
 	  // $error=false;
   	}
   	else {
   		$error = true;
   	}

   	$p = new Project();
    $pid = $p->getProjectIdByName($project);
   	$pnames = $p->getProjectNameById($project);
   	$id = $pid['areaId'];
   
    if($DBO->delete('qa_stockUpdates_small',"areaId='$project' AND vehicleNo='$vehicleNo' AND date='$date'")){
    	//$error = false;
    }
    else {
    	$error = true;
    }
   	
   	if($DBO->delete('qa_centerQuantitySmall',"id='$project' AND vehicleNo='$vehicleNo' AND date='$date' ")){
    	//$error = false;
   	}
   	else {
   		$error = true;
   	}
   
   	if($DBO->delete('qa_confirmed_stocks',"id='$project' AND vehicleNo='$vehicleNo' AND date='$date' ")){
	//	$error = false;
	}
	else {
		$error = true;
	}
   
   	if(!$error){
	   	print '1';
	   	$logString="User :' ".$_SESSION['SESS_MEMBER_ID']." ' deleted data(Small). of project :' ".$pnames['areaName']." ' with Vehicle number :' ".$vehicleNo." ' in date :' ".$date." ' . Succeeded";
	    $log->log(date('Y-m-d h:i:s'), $logString);
   	
   	}
   	else {  
	   print '0';
	   $logString="User :' ".$_SESSION['SESS_MEMBER_ID']." ' tried to delete data(Small). of project :' ".$pnames['areaName']." ' with Vehicle number :' ".$vehicleNo." ' in date :' ".$date." ' . But unsucceeded";
	   $log->log(date('Y-m-d h:i:s'), $logString);
   	}
}

?>