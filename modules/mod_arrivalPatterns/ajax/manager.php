<?php
require_once '../../../includes/HDatabase.php';
require_once '../../../libraries/base/pattern/lib_pattern.php';
require_once '../../../libraries/base/project/lib_project.php';
require_once '../../../libraries/base/season/lib_season.php';
require_once '../class/Plan.php';
if(isset($_POST)){
	$plan = new Plan();
	$revision = new Revisions();
	$pHandler = new PatternHandler();
	$flag = $_POST['flag'];
	
	if($flag == "getPlan") {
		$p = $_POST['project'];
		$s = $_POST['season'];
		$plans = $plan->getPlans($p, $s);
		print json_encode($plans);
	}
	else if($flag == "getRevisions") {
		$p = $_POST['project'];
        $s = $_POST['season'];
		$revisions = $revision->getRevisions($p, $s);
		print json_encode($revisions);
        
	}
	else if($flag == 'getPatternValues') {
		$p = $_POST['project'];
        $s = $_POST['season'];
        $values = $_POST['values'];
		$scheme = $pHandler->getScheme($p,$s);
		$ypa = $pHandler->getYPA($p,$s);
		$patternValues=$pHandler->getCalculation($values, $scheme, $ypa);
		echo json_encode($patternValues);
		
	}
	else if($flag == 'getProjectId') {
		header('Content-type:application/json');
		$pid = $_POST['project'];
		$p = new Project();
		$projectName = $p->getProjectNameById($pid);
		header('Content-type:application/json');
		echo json_encode(array('success' => true, 'name' => $projectName['areaName']));
		
	}else if($flag == 'getSeasonId') {
        $sid = $_POST['season'];
        $s = new Season();
        $seasonName = $s->getSeasonNameById($sid);
        echo  $seasonName;
        
    }
}
?>