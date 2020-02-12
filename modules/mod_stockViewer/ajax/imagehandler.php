<?php
require_once '../../../includes/HDatabase.php';
if(isset($_POST)){
	$project=$_POST['project'];
	$vehicle=$_POST['vehicle'];
	$date=$_POST['date'];
	
	$db=new HDatabase();
	$db->connect();
	$db->select('qa_stockImages','*',"id='$project' AND date='$date' AND vehicleNo='$vehicle'");
	$rea=$db->getResult();
	
	print json_encode( $rea[0] );
	
}









?>