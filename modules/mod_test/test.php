<?php 
/* 
$db = new HDatabase();
$db->setDBName('qa_small_cropz')->connect();
$db->query('SELECT * FROM qa_small_crop');
$old = $db->getResult();
//var_dump($old);1372610458
foreach ($old as $entry){
	$id = getProjectId($entry['project']);
	$insert = array($id,
			$entry['date'],
			$entry['gradeName'],
			$entry['project'],
			$entry['vehicleNo'],
			$entry['sampleId'],
			$entry['sampleNo'],
			0,	
			0,
			0,
			$entry['mellonFlyAttacked'],
			$entry['peeledOff'],
			$entry['boreAttacked'],
			0,
			$entry['shrivelled'],
			0,
			0,
			$entry['mechanicalDamaged'],
			$entry['yellowish'],
			$entry['rustPatches'],
			0,
			0,
			$entry['rotten'],
			$entry['totalDefects']
			);
	$db->insert('qa_small_cropSampleGradesv2', $insert);
}

function getProjectId($name){
	error_log('name:'.$name);
	$db = new HDatabase();
	$db->setDBName('quality_orig')->connect();
	$db->query('SELECT * FROM qa_area WHERE areaName="'.$name.'"');
	$res = $db->getResult();
	$r = array_pop($res);
	error_log('Got a id for '.$name.' : '.$r['areaId']);
	return $r['areaId'];
	
}

function getGradeId($name){
	$db = new HDatabase();
	$db->setDBName('quality_orig')->connect();
	$db->query('SELECT * FROM qa_gradeCategory WHERE name="'.$name.'"');
	$res = $db->getResult();
	$r = array_pop($res);
	error_log('Got a id for '.$name.' : '.$r['id']);
	return $r['id'];
} */
?>