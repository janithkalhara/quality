<?php
require_once '../../../includes/HDatabase.php';
if(isset($_POST)){
	if($_POST['flag']=='addReport'){
		
		addReport($_POST);
		
	}
	
	
	
}

function addReport($_POST){
	$db=new HDatabase();
	$db->connect();
	
	/* Collecting data*/
	$date=$_POST['date'];
	$project=$_POST['project'];
	$vehicleNo=$_POST['vehicle'];
	$report=$_POST['report'];
	file_put_contents("test.html",$report);
	
	
	
	/* adding report to database*/
	if($db->insert('qa_reports', array($date,$project,$vehicleNo,$report))){
	print('The Report added to the Archive  Successfully!');
	}else {
		print "Cannot save the report";
	}
	
}




?>