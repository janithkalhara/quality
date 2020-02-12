<?php
require_once '../../../includes/HDatabase.php';
require_once '../../../libraries/base/project/lib_project.php';
require_once '../class/stockViewer.class.php';

if(isset($_POST)){
	$id = $_POST['id'];
    $project = $id[0];
    $vehicleNo = $id[1];
    $date = $id[2];
	$reportgenerator=new reportGenerator($date, $vehicleNo, $project);
	$reportgenerator->renderReport();
}
?>