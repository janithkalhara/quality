<?php
require_once '../../../includes/HDatabase.php';
if(isset($_POST)){
	$project = $_POST['project'];
	$vehicle = $_POST['vehicle'];
	$date = $_POST['date'];
	$db = new HDatabase();
	$db->connect();
	$db->select('qa_stockImagesSmall','*',"id='$project' AND date='$date' AND vehicleNo='$vehicle'");
	$res = $db->getResult();
	$imgArray=$res[0];
	if($imgArray){
		
		$img_projectName = str_replace("-", "",$project);
		$img_date = str_replace(" ", "",$date);
		$img_date = str_replace("-", "",$img_date);
		$img_date = str_replace(":", "",$img_date);
		$img_vehicle = str_replace("-", "",$vehicle);
		$img_vehicle = str_replace(" ", "",$img_vehicle);
		$prefix = $img_date.$img_projectName.$vehicle;
		$images = array();
		$a = array();
		for($i=0;$i<3;$i++){
			if($imgArray['image'.($i+1)]!=null){
				$a["image"]=$prefix.$imgArray['image'.($i+1)];
				$a['desc']=$imgArray['image_desc'.($i+1)];
				$images[$i]=$a;
			}
		}
		echo json_encode(array('success'=>true,'data'=>$images));
		exit();
	}
	else{
		echo json_encode(array('success'=>false));
		exit();
	}
}
?>