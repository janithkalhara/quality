<?php
session_start();
require_once '../../../includes/HDatabase.php';
require_once '../../../libraries/base/project/lib_project.php';
require_once '../../../includes/Logger.php';

$handler = new dataHandler();
if(isset($_POST)){
	$flag=$_POST['flag'];
	if($flag=="save"){
		
		$handler->saveCrop($_POST['saveCrop']);
		$handler->saveGradeData($_POST['saveGradeData']);
		$handler->saveGradeSampleData($_POST['saveGradeSampleData']);
		$handler->saveGradeSampleCRSData($_POST['saveGradeSampleCRSData']);
		$handler->saveImageData($_POST['saveImageData']);
		$handler->saveCenterQuantity($_POST['saveCenterQuantity']);
		$handler->saveUserData($_POST['saveUserData']);
	}

}


class dataHandler{

	private $stock_error;

	public function dataHandler(){
		$this->stock_error = false;
		
	}
	
	function saveCrop($post){
		$id = $post['projectId'];
		$project = $post['project'];
		$centers = $post['centers'];
		$date = $post['date'];
		$batchNo = $post['batchNo'];
		$vehicleNo = $post['vehicleNo'];
		$itmNo = $post['itmNo'];
		$totalOffGrade = $post['totalOffGrade'];
		$totalData = $post['totalData'];
		$numOfCrates = $post['numOfCrates'];
		$tmnumbers = $post['tmnumbers'];
		$transportData = $post['transport'];
		$respond = array('ඇත','නැත');
		$insert = array($id,$project,$centers,$date,$batchNo,$vehicleNo,$itmNo,$totalOffGrade);
		
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
		 
		//init rows
		$rows = "'id','project','centers','date','batchNo','vehicleNo','itmNo','totalOffGrade','total_DQ','total_AQ',";
		$rows.= "'11-14Q','14-17Q','17-29Q','29-44Q','crs','rejected','hiddenLoss','weightLoss','transport-delivery','transport-cover','transport-smell','transport-otherThings','transport-labels','transport-QualityReport','noOfCrates','tmNumbers'";
		//there was an issue in passing row to the dbo->insert
		//in future this should be handled.think _,- marks area causing to the bug

		$DBO = new HDatabase();
		$DBO->connect();
		if($DBO->insert('qa_small_crop', $insert)){
		
		}
		else {
			$this->setError();
		}	
	}

	function saveGradeData($post){
		$grades = array("11-14","14-17","17-29","29-44","CRS");
		$pid = $post['projectId'];
		$project = $post['project'];
		$date = $post['date'];
		$vehicleNo = $post['vehicleNo'];
		$totalData = $post['totalData'];
		$offGrades = $post['offGrades'];
		$DBO = new HDatabase();
		$DBO->connect();
		$error = false;
		for($i = 0;$i<5;$i++){
			//$str=$date.'^'.$project.'^'.$vehicleNo.'^'.$grades[$i].'^'.implode('^', $totalData[$i]);
			$insert = array($pid,$date,$project,$vehicleNo,$grades[$i]);
			foreach ($totalData[$i]['data'] as $temp){
				array_push($insert, $temp);
			}
			$insert = array_merge($insert,array($totalData[$i]['mode'] == 'true'?1:0,$totalData[$i]['afc']));
			$rows = "'id','date','project','vehicleNo','gradeName','DQ','AQ','g1114','g1417','g1729','g2944','CRS','reject','hiddenLoss','weightLoss','offGrade'";
			if($DBO->insert('qa_small_belongs', $insert)){
			}
			else {
				$this->setError();
			}
		}
		
	}

	function saveGradeSampleData($post){
		$grades = array("11-14","14-17","17-29","29-44","CRS");
		$pid = $post['projectId'];
		$project = $post['project'];
		$date = $post['date'];
		$vehicleNo = $post['vehicleNo'];
		$samples = $post['samples'];
		$storeSamples = array();
		$ds = new HDatabase();
		$ds->connect();
		$error = false;

		/* insert to qa_small_cropGrades*/
		$tracker = 0;
		foreach ($samples as $grade){
			$mode = $grade['mode']=='false'?false:true;
			$data = $mode?$grade['data']:null;
			if($mode){
				$pers = $mode?$grade['data']['pers']:null;
				$sums = $mode?$grade['data']['sums']:null;
				array_pop($pers);array_pop($sums);	
				$sampleStatInsert_base = array($pid,$date,$vehicleNo,$grades[$tracker]);
				//insert into sample stat table
				if(($size = count($pers)) == count($sums)){
					for($i=0;$i<$size;$i++){
						array_push($sampleStatInsert_base,implode('-', array($sums[$i],$pers[$i])));
					}
					if($ds->insert('qa_small_cropSampleStat', $sampleStatInsert_base)){
						
					}
					else {
						$error = true;
					}
				}
			}
			$samplesArray = array($pid,$date,$grades[$tracker],'',$vehicleNo);	
			$inSamples = $grade['data']['samples'];
			for($i = 0;$i<13;$i++){
				if($inSamples[$i][0] != '0' && $inSamples[$i][0] != ''){
					$prependable = array($i);
					$insert = array_merge($samplesArray,$prependable,$inSamples[$i]);
					if($ds->insert('qa_small_cropSampleGrades2', $insert)){
					}
					else{
						$error = true;
					}
				}
			} 
			$tracker++;
		}
		if($error) $this->setError();
	}

	function saveGradeSampleCRSData($post){
		$pid = $post['projectId'];
		$project = $post['project'];
		$date = $post['date'];
		$vehicleNo = $post['vehicleNo'];
		$samples = isset($post['crs_samples']) ? $post['crs_samples'] : array();
		
		if(count($samples) <= 0) { $this->setError(); return false; }
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
		$DBO = new HDatabase();
		$DBO->connect();
		if($DBO->insert('qa_small_crsData', $insert)){
		}
		else{
			$this->setError();
		}
		$error = false;
		for($i = 0; $i<13; $i++){
			if($crsSamples[$i][0] != 0){
					
				$insert_crs_samples = array($pid,$project,$date,$vehicleNo,$i);
				foreach ($crsSamples[$i] as $temp){
					array_push($insert_crs_samples,$temp);
				}
				if($DBO->insert('qa_small_crsSampleData', $insert_crs_samples)){
				}
				else{
					$error=true;
				}
			}
		}
		if($error){
			$this->setError();
		}
	}

	function saveImageData($post){
		$pid = $post['projectId'];
		$project = $post['project'];
		$date = $post['date'];
		$vehicleNo = $post['vehicleNo'];
		$images = $post['images'];
		$imageDescs = $post['imagesDesc'];
			
		$data = array($pid,$project,$date,$vehicleNo);
		array_push($data, $images[0]);
		array_push($data, $images[1]);
		array_push($data, $images[2]);
		array_push($data, $imageDescs[0]);
		array_push($data, $imageDescs[1]);
		array_push($data, $imageDescs[2]);
			
		$db = new HDatabase();
		$db->connect();
		
		if($db->insert('qa_stockImagesSmall', $data)){
		}
		else{
			$this->setError();
		} 
	}
	
	public function saveCenterQuantity($post){
		$dataArray = $post;
		$db = new HDatabase();
		$db->connect();
		$error=false;
		for($i = 0; $i<count($dataArray); $i++){
			$db->resetResult();
			if($db->insert('qa_centerQuantitySmall', $dataArray[$i])){
			}
			else{
				$error=true;
			}
			$db->resetResult();
		}
		if($error){
			$this->setError();
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
		$db=new HDatabase();
		$db->connect();
		$db->select('qa_station','stationId',"stationName='$station'");
		$res = $db->getResult();
		$stationId = $res['stationId'];
		
		$insert = array($vehicleNo,$user,$station,$date,$pid);
		$rows = "vehicleNo,userId,stationId,date,areaId";
		if($db->insert('qa_stockUpdates_small', $insert)){
		}
		else {
			$this->setError();
		}
		header('Content-type:application/json');
		if($this->getErrorState()!="true"){
			echo json_encode(array('success'=>true,'message'=>'Data Submitted Successfully!'));
			$logString="User :' ".$user." ' added data(Small grade). in project :' ".$project." ' with Vehicle number :' ".$vehicleNo." ' for date :' ".$date." ' . Succeeded";
			$log->log(date('Y-m-d h:i:s'), $logString);
			$db->resetResult();
			$db->insert("qa_confirmed_stocks", array($pid,$vehicleNo,$date));	
		}
		else{
			if($this->getConfirmedStock($pid, $vehicleNo, $date)){
				echo json_encode(array('success'=>false,'message'=>'You have submitted existing stock data.\nPlease try with diffrent stock data.'));
			}
			else{
				echo json_encode(array('success'=>false,'message'=>'There were some errors occured.Please Check Your Insertion Data!'));
				$this->deleteStock($pid, $vehicleNo, $date);
			}
			$logString="User ' ".$user." ' tried to add data(Small grade). in project :'".$project."' with Vehicle number :'".$vehicleNo."' for date :'".$date."' . But not succeeded";
			$log->log(date('Y-m-d h:i:s'),$logString);
		}
	}
	
	function setError(){
		$this->stock_error=true;
	}

	function resetError(){
		$this->stock_error=false;
	}
	
	function getErrorState(){
		return $this->stock_error;
	}
	
	function getConfirmedStock($p,$v,$d){
		$db = new HDatabase();
		$db->connect();
		$db->select("qa_confirmed_stocks","*","id='$p' AND vehicleNo='$v' AND date='$d'");
		$res = $db->getResult();
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
	
	function deleteStock($p,$v,$d){
		$db = new HDatabase();
		$db->connect();
		$db->delete("qa_small_crop","id='$p' AND vehicleNo='$v' AND date='$d'");
		$db->delete("qa_small_belongs","id='$p' AND vehicleNo='$v' AND date='$d'");
		$db->delete("qa_small_cropSampleGrades2","id='$p' AND vehicleNo='$v' AND date='$d'");
		$db->delete("qa_small_cropSampleStat","id='$p' AND vehicleNo='$v' AND date='$d'");
		$db->delete("qa_small_crsData","id='$p' AND vehicleNo='$v' AND date='$d'");
		$db->delete("qa_small_crsSampleData","id='$p' AND vehicleNo='$v' AND date='$d'");
		$db->delete("qa_stockImagesSmall","id='$p' AND vehicleNo='$v' AND date='$d'");
		$db->delete("qa_centerQuantitySmall","id='$p' AND vehicleNo='$v' AND date='$d'");
		$db->delete("qa_stockUpdates_small","areaId='$p' AND vehicleNo='$v' AND date='$d' AND userId='".$_SESSION['SESS_MEMBER_ID']."'");
		$db->delete("qa_confirmed_stocks","id='$p' AND vehicleNo='$v' AND date='$d'");
	}
}
?>