<?php
require_once '../class/renderer.class.php';
require_once '../../../libraries/base/project/lib_project.php';

if(isset($_POST)){
	$id = $_POST['id'];
	$type = $_POST['type'];

	$project = $id[0];
	$vehicleNo = $id[1];
	$date = $id[2];
	$renderer = new renderer($vehicleNo, $project, $date);
	$renderer->setHeaderData();
	$renderer->collectReportData();
	$renderer->setBalanceSheetData();
	
	if($type == 'qreport'){
		$renderer->renderQualityReport();
	}
	else{
		$renderer->renderBalanceSheet();
	}

}
?>