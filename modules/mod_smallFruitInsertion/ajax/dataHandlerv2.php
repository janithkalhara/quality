<?php
session_start();
require_once '../../../includes/HDatabase.php';
require_once '../../../libraries/base/project/lib_project.php';
require_once '../../../includes/Logger.php';

if(isset($_POST)){
	$p = $_POST['saveCrop']['projectId'];
	$v = $_POST['saveCrop']['vehicleNo'];
	$d = $_POST['saveCrop']['date'];
	$project = $_POST['saveCrop']['project'];
	$user = $_SESSION['SESS_MEMBER_ID']; 
	$handler = new DataHandler($p, $v, $d);
	$db = HDatabase::getInstance();
	$flag = $_POST['flag'];
	$log = new Logger("../../../logfile.log");
	if($flag == "save"){
		try {
			$handler->saveCrop($_POST['saveCrop']);
			$handler->saveGradeData($_POST['saveGradeData']);
			$handler->saveGradeSampleData($_POST['saveGradeSampleData']);
			$handler->saveGradeSampleCRSData($_POST['saveGradeSampleCRSData']);
			$handler->saveImageData($_POST['saveImageData']);
			$handler->saveCenterQuantity($_POST['saveCenterQuantity']);
			$handler->saveUserData($_POST['saveUserData']); 
			
			header('Content-type:application/json');
			echo json_encode(array('success' => true,'message' => 'Data Submitted Successfully!'));
			$logString="User :' ".$user." ' added data(Small grade). in project :' ".$project." ' with Vehicle number :' ".$v." ' for date :' ".$d." ' . Succeeded";
			$log->log(date('Y-m-d h:i:s'), $logString);
			$db->insert("qa_confirmed_stocks", array($p,$v,$d));
			
		}
		catch (Exception $e) {
			header('Content-type:application/json');

			if($handler->getConfirmedStock($p, $v, $d)){
				echo json_encode(array('success' => false,'message' => 'You have submitted existing stock data.\nPlease try with diffrent stock data.'));
			}
			else{
				echo json_encode(array('success'=>false,'message'=>'There were some errors occured.Please Check Your Insertion Data!'));
				$handler->deleteStock($p, $v, $d);
			}
			$logString = "User ' ".$user." ' tried to add data(Small grade). in project :'".$project."' with Vehicle number :'".$v."' for date :'".$d."' . But not succeeded";
			$log->log(date('Y-m-d h:i:s'),$logString);
		}
	}

}

class DataHandler {
	private $_db;
	
	private $p;
	private $v;
	private $d;
	
	public function __construct($p, $v, $d) {
		$this->_db = HDatabase::getInstance();
		$this->p = $p; $this->v = $v; $this->d = $d;
	}
	
	public function saveCrop($data) {
		
		$id = $this->p;
		$project = $data['project'];
		$centers = $data['centers'];
		$date = $this->d;
		$batchNo = $data['batchNo'];
		$vehicleNo = $this->v;
		$itmNo = $data['itmNo'];
		$totalOffGrade = $data['totalOffGrade'];
		$totalData = $data['totalData'];
		$numOfCrates = $data['numOfCrates'];
		$tmnumbers = $data['tmnumbers'];
		$transportData = $data['transport'];
		$respond = array('ඇත','නැත');
		$insert = array($id,$centers,$date,$batchNo,$vehicleNo,$itmNo,$totalOffGrade);
		
		foreach ($totalData as $temp){
			array_push($insert,$temp);
		}
			
		array_push($insert, $transportData[0]);
		array_push($insert, $transportData[1]);
		array_push($insert, $transportData[2]);
		array_push($insert, $transportData[3]);
		array_push($insert, $transportData[4]);
		array_push($insert, $transportData[5]);
		array_push($insert, $numOfCrates);
		array_push($insert, $tmnumbers);
		error_log(json_encode($insert));
		$rows = "`id`,`centers`,`date`,`batchNo`,`vehicleNo`,`itmNo`,`totalOffGrade`,`total_DQ`,`total_AQ`,";
		$rows.= "`11-14Q`,`14-17Q`,`17-29Q`,`29-44Q`,`crs`,`rejected`,`hiddenLoss`,`weightLoss`,`transport-delivery`,`transport-cover`,`transport-smell`,`transport-otherThings`,`transport-labels`,`transport-QualityReport`,`noOfCrates`,`tmNumbers`";
		//there was an issue in passing row to the dbo->insert
		//in future this should be handled.think _,- marks area causing to the bug
		if($this->_db->insert('qa_small_crop', $insert,$rows)){
		
		}
		else {
			throw new Exception('Unable to save crop data',110);
		}
	}
	
	public function saveGradeData($data) {
		$grades = array("11-14","14-17","17-29","29-44","CRS");
		$pid = $this->p;
		$project = $data['project'];
		$date = $this->d;
		$vehicleNo = $this->v;
		$totalData = $data['totalData'];
		$offGrades = $data['offGrades'];
		for($i = 0;$i<5;$i++) {
			$insert = array($pid,$date,$project,$vehicleNo,$grades[$i]);
			foreach ($totalData[$i]['data'] as $temp){
				array_push($insert, $temp);
			}
			$insert = array_merge($insert,array($totalData[$i]['mode'] == 'true' ? 1 : 0,$totalData[$i]['afc']));
			$rows = "`id`,`date`,`project`,`vehicleNo`,`gradeName`,`DQ`,`AQ`,`11-14`,`14-17`,`17-29`,`29-44`,`CRS`,`reject`,`hiddenLoss`,`weightLoss`,`offGrade`,`mode`,`afc`";
			if($this->_db->insert('qa_small_belongs', $insert,$rows)){
				
			}
			else {
				throw new Exception('Unable to save crop grade data',111);
			}
		}
		
	}
	
	function saveGradeSampleData($post){
		$grades = array("11-14","14-17","17-29","29-44","CRS");
		$pid = $this->p;
		$project = $post['project'];
		$date = $this->d;
		$vehicleNo = $this->v;
		$samples = isset($post['samples']) ? $post['samples'] : array();
		$storeSamples = array();
		$tracker = 0;
		foreach ($samples as $grade){
			error_log('Mode is '.$grade['mode']);
			$mode = $grade['mode'] == 'false' ? false : true;
			$data = $mode ? $grade['data'] : null;
			if($mode) {
				error_log(json_encode($grade['data']));
				$pers = $mode ? $grade['data']['pers'] : null;
				$sums = $mode ? $grade['data']['sums'] : null;
				array_pop($pers);array_pop($sums);
				$sampleStatInsert_base = array($pid,$date,$vehicleNo,$grades[$tracker]);
				//insert into sample stat table
				if(($size = count($pers)) == count($sums)){
					for($i=0;$i<$size;$i++){
						array_push($sampleStatInsert_base,implode('-', array($sums[$i],$pers[$i])));
					}
					
					if($this->_db->insert('qa_small_cropSampleStat', $sampleStatInsert_base)){
					}
					else {
						throw new Exception('Unable to save crop grade data',112);
					}
				}
			}
			$samplesArray = array($pid,$date,$grades[$tracker],'',$vehicleNo);
			$inSamples = $grade['data']['samples'];
			for($i = 0;$i<13;$i++){
				if($inSamples[$i][0] != '0' && $inSamples[$i][0] != ''){
					$prependable = array($i);
					$insert = array_merge($samplesArray,$prependable,$inSamples[$i]);
					if($this->_db->insert('qa_small_cropSampleGrades2', $insert)){
					}
					else{
						throw new Exception('Unable to save crop grade samples',113);
					}
				}
			}
			$tracker++;
		}
	}
	

	function saveGradeSampleCRSData($post){
		$pid =  $this->p;
		$project = $post['project'];
		$date = $this->d;
		$vehicleNo = $this->v;
		$samples = isset($post['crs_samples']) ? $post['crs_samples'] : array();
	
		if(count($samples) <= 0) { return false; }
		$crsSamples = array();
		$crsSumsPers = array();
		for($i = 0; $i<13; $i++){
			for($j = 0; $j<13; $j++){
				$crsSamples[$i][$j] = isset($samples[$i][$j]) ? $samples[$i][$j] : 0;
			}
		}
		for($j = 1; $j<13; $j++){
			$crsSumsPers[$j] = $samples[13][$j]."-".$samples[14][$j];
		}
		$insert = array($pid,$project,$date,$vehicleNo);
		foreach ($crsSumsPers as $temp){
			array_push($insert, $temp);
		}
		
		if($this->_db->insert('qa_small_crsData', $insert)){
		}
		else{
			throw new Exception('Unable to save crop grade CRS data',114);
		}
		for($i = 0; $i<13; $i++){
			if($crsSamples[$i][0] != 0){
					
				$insert_crs_samples = array($pid,$project,$date,$vehicleNo,$i);
				foreach ($crsSamples[$i] as $temp){
					array_push($insert_crs_samples,$temp);
				}

				if($this->_db->insert('qa_small_crsSampleData', $insert_crs_samples)){
				}
				else{
					throw new Exception('Unable to save crop grade CRS samples',115);
				}
			}
		}
	}
	
	function saveImageData($post){
		$pid = $this->p;
		$project = $post['project'];
		$date = $this->d;
		$vehicleNo = $this->v;
		$images = $post['images'];
		$imageDescs = $post['imagesDesc'];
			
		$data = array($pid,$project,$date,$vehicleNo);
		array_push($data, $images[0]);
		array_push($data, $images[1]);
		array_push($data, $images[2]);
		array_push($data, $imageDescs[0]);
		array_push($data, $imageDescs[1]);
		array_push($data, $imageDescs[2]);
		
		if($this->_db->insert('qa_stockImagesSmall', $data)) {

		}
		else {
			throw new Exception('Unable to save crop grade CRS samples',115);
		}
	}
	
	public function saveCenterQuantity($post){
		$dataArray = $post;
		for($i = 0; $i<count($dataArray); $i++){
			
			if($this->_db->insert('qa_centerQuantitySmall', $dataArray[$i])){
			}
			else{
				throw new Exception('Unable to save center quanity data',115);
			}
		}
	}
	
	public function saveUserData($post){
		$pid = $post['projectId'];
		$project = $post['project'];
		$date = $post['date'];
		$vehicleNo = $post['vehicleNo'];
		$station = $post['station'];
		$log = new Logger("../../../logfile.log");
		$user = $_SESSION['SESS_MEMBER_ID'];
		
		$this->_db->select('qa_station','stationId',"stationName='$station'");
		$res = $this->_db->getResult();
		$stationId = $res['stationId'];
	
		$insert = array($vehicleNo,$user,$station,$date,$pid);
		$rows = "vehicleNo,userId,stationId,date,areaId";
		if($this->_db->insert('qa_stockUpdates_small', $insert)){
		}
		else {
			throw new Exception('Unable to save user data ',116);
		}
		
	}
	
	function getConfirmedStock($p,$v,$d){
		$this->_db->select("qa_confirmed_stocks","*","id='$p' AND vehicleNo='$v' AND date='$d'");
		$res = $this->_db->getResult();
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
	
	function deleteStock($p,$v,$d){
		$this->_db->delete("qa_small_crop","id='$p' AND vehicleNo='$v' AND date='$d'");
		$this->_db->delete("qa_small_belongs","id='$p' AND vehicleNo='$v' AND date='$d'");
		$this->_db->delete("qa_small_cropSampleGrades2","id='$p' AND vehicleNo='$v' AND date='$d'");
		$this->_db->delete("qa_small_cropSampleStat","id='$p' AND vehicleNo='$v' AND date='$d'");
		$this->_db->delete("qa_small_crsData","id='$p' AND vehicleNo='$v' AND date='$d'");
		$this->_db->delete("qa_small_crsSampleData","id='$p' AND vehicleNo='$v' AND date='$d'");
		$this->_db->delete("qa_stockImagesSmall","id='$p' AND vehicleNo='$v' AND date='$d'");
		$this->_db->delete("qa_centerQuantitySmall","id='$p' AND vehicleNo='$v' AND date='$d'");
		$this->_db->delete("qa_stockUpdates_small","areaId='$p' AND vehicleNo='$v' AND date='$d' AND userId='".$_SESSION['SESS_MEMBER_ID']."'");
		$this->_db->delete("qa_confirmed_stocks","id='$p' AND vehicleNo='$v' AND date='$d'");
	}
} 
?>