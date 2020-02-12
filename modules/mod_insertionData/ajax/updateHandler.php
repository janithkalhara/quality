<?php
session_start();
require_once '../../../includes/HDatabase.php';
require_once '../../../roles/user.php';
require_once '../../../libraries/base/project/lib_project.php';
require_once '../../../includes/Logger.php';
require_once '../../../libraries/base/season/lib_season.php';
require_once 'restore.php';
if(isset($_POST['flag']) && $_POST['flag']=='update'){
	
	$headers=$_POST['headers'];
	$tms=$_POST['tms'];
	$stocks=$_POST['stocks'];
	$samples=$_POST['samples'];
	
	
	$handler=new Handler($headers,$stocks,$samples,$tms);
	
}

class Handler{
	private $id;
	private $date;
	private $vehicleNo;
	private $user;
	private $db;
	private $restore;
	private $stocks;
	private $samples;
	private $tms;
	private $headers;
	private $error_flag=false;
	private $stockMap=array('noOfCrates','notedWeight','trueWeight','averageFruitCount','fruitCount','sumOfSmallFruit','sumOfLargeFruit',
				'sumOfFlyAttacked','sumOfPeeledOff','sumOfBoreAttacked','sumOfSandEmbedded','sumOfShrivelled','sumOfDeformed','sumOfVirusAttacked',
				'sumOfMechanicalDamaged','sumOfYellowish','sumOfRustPatches','sumOf45','sumOfRotten','totalPerOfDefectGrade','totalPerOfDefect',
				'reducedPerOfDefectGrade','reducedPerOfDefect','payableQuantity');
	private $sampleMap=array('fruitCount','smallFruit','largeFruit','flyAttacked','peeledOff','boreAttacked',
				'sandEmbedded','shrivelled','deformed','virusAttacked','mechanicalDamaged','yellowish','rustPatches','fruits45','accepted','spoiled');
	public function __construct($h,$stocks,$samples,$tms){
		
		$this->id=$h['project'];
		$this->date=$h['date'];
		$this->vehicleNo=$h['vehicleNo'];
		$data=unserialize($_SESSION['data']);
		$this->db=new HDatabase();
		$this->db->connect();
		//assigning args to object vars 
		$this->stocks=$stocks;
		$this->samples=$samples;
		$this->tms=$tms;
		$this->headers=$h;
		
		if($data->id==$this->id){
			//in here the previous data set should be deleted 
			$this->restore=new Restore($data->id, $data->v,$data->d);
			$this->restore->load();
			
			$this->deleteStock($data->id, $data->v, $data->d);
			$insert=array($this->id,$h['dq'],$this->vehicleNo,
					$h['params']['delivery'],
					$h['params']['cover'],
					$h['params']['smell'],
					$h['params']['otherThings'],
					$h['params']['colorcode'],
					$h['params']['qualityReport'],
					$this->date);
			$rows="id,quantity,vehicleNo,handovering,lorryCovering,badSmell,otherGoods,labelling,qualityReports,date";
			
			if($this->db->insert('qa_stock', $insert,$rows)){
				$this->saveStocks();
				
			}else{
				error_log('error - stock');
				$this->error_flag=true;
				return false;
			}
			return true;
			
		}else{
			header('Content-type:application/json');
			print json_encode(array('status'=>false,'message'=>'Data not valid. Either your session has been expired or\n you are trying to submit another stock data'));
			exit();
		}
		//remove the existing project
	}
	
	function saveStocks(){
		
		$cols='id,vehicleNo,date,gradeId,noOfCrates,notedWeight,trueWeight,averageFruitCount,fruitCount,sumOfSmallFruit,sumOfLargeFruit,
				sumOfFlyAttacked,sumOfPeeledOff,sumOfBoreAttacked,sumOfSandEmbedded,sumOfShrivelled,sumOfDeformed,sumOfVirusAttacked,
				sumOfMechanicalDamaged,sumOfYellowish,sumOfRustPatches,sumOf45,sumOfRotten,totalPerOfDefectGrade,totalPerOfDefect,
				reducedPerOfDefectGrade,reducedPerOfDefect,payableQuantity';
		$flag=true;
		foreach ($this->stocks as $stock){	
			
			$insert=array($this->id,$this->vehicleNo,$this->date,$stock['grade']);
			$mergeable=array();
			foreach ($this->stockMap as $tempKey){
				array_push($mergeable,$stock[$tempKey]);
			}
				
			$insert=array_merge($insert,$mergeable);
			if($this->db->insert('qa_gradeStock',$insert,$cols)){
				
			}else{
			
				
				$flag= false;
			}
		}
		if($flag){
			//no error on saving grade stocks 
			//save samples 
			$this->saveSamples();
		}else{
			//set the error message
			error_log('save stocks---error');
			$this->error_flag=true;
		}
	}
	
	function saveSamples(){
		
		$cols='id,sampleId,vehicleNo,gradeId,centerId,date,fruitCount,smallFruit,largeFruit,flyAttacked,peeledOff,boreAttacked,
				sandEmbedded,shrivelled,deformed,virusAttacked,mechanicalDamaged,yellowish,rustPatches,fruits45,accepted,spoiled';
		$flag=true;
		foreach ($this->samples as $sample){
			$insert=array($this->id,$sample['sampleId'],$this->vehicleNo,$sample['grade'],$sample['centerId'],$this->date);			
			$mergeable=array();
			foreach ($this->sampleMap as $tempKey){
				if(isset($sample[$tempKey]))
					array_push($mergeable, $sample[$tempKey]);
				else
					array_push($mergeable,0);
			}
			$insert=array_merge($insert,$mergeable);
			if($this->db->insert('qa_sample',$insert,$cols)){
				
			}else{
				
				error_log('save samples---error');
				$flag=false;
			}
		}
		if(!$flag){
			//there is an error
			$this->error_flag=true;
		}else{
			//insertion is ok.then save center quantities
			$this->saveCenteFakes();	
		}
		
		
	}
	
	function saveCenteFakes(){
		$cols='id,seasonId,date,vehicleNo,centerFakeId,centerName,TMno';
		$season=new Season();
		$seasonId=$season->getOngoingSeasonId();
		$i=0;$flag=true;
		foreach ($this->headers['centers'] as $center){
			$insert=array($this->id,$seasonId,$this->date,$this->vehicleNo,$i,$center['center'],$center['tm']);
			
			if($this->db->insert('qa_center_fakes', $insert,$cols)){
				$i++;
			}else{
				$flag=false;
			}
		}
		if(!$flag){
			//error
			error_log('save center fakes ---error');
			$this->error_flag=true;
		}
		else{
			//keep saving. save center quantities.
			$this->saveCenterQuantities();
		}		
		
	}
	function saveCenterQuantities(){
				
		//save tm table data
		$cols='id,date,vehicleNo,center,tmNo,grade1,grade2,grade3,grade4';
		$flag=true;
		foreach ($this->tms as $tm){
			
			$insert=array($this->id,$this->date,$this->vehicleNo,$tm['center'],$tm['tm'],$tm['grade1'],$tm['grade2'],$tm['grade3'],$tm['grade4']);
			if($this->db->insert('qa_centerQuantity',$insert,$cols)){
			}else {
				$flag=false;
			}
		}
		if(!$flag){
			//error
			error_log('save center quantity ---error');
			$this->error_flag=true;
		}else{
			//keep saving stock updates
			$this->saveStockUpdates();
		}
	}
	
	public function saveStockUpdates(){
		
		$cols='vehicleNo,userId,stationId,date,areaId';
		$userId=$_SESSION['SESS_MEMBER_ID'];
		$user=new user();
		$flag=true;
		$station=$user->getUserStation();
		$insert=array($this->vehicleNo,$userId,$station,$this->date,$this->id);
		if($this->db->insert('qa_stockUpdates', $insert,$cols)){
			
		}else{
			$this->error_flag=true;
			error_log('save stock updates ---error');
			
			$flag=false;
		}
		
	}
	public function __destruct(){
		header("Content-type:application/json");
		if(!$this->error_flag){
			$id=json_encode(array($this->id,$this->vehicleNo,$this->date));
			echo json_encode(array('success'=>true,'message'=>'Data updated successfully','url'=>'home.php?option=mod_insertionData&action=edit&id='.urlencode($id)));
			exit();
		}else{
			//delete new trying stock data 
			$this->deleteStock($this->id, $this->vehicleNo, $this->date);
			$this->restore->restore();
			echo json_encode(array('success'=>false,'message'=>'There was an error occured updating data.\n Previous data will be restored.'));
			exit();
		}
	}
	private function deleteStock($p,$v,$d){
		
		/*
		 * deleting stock table
		*/
		$this->db->delete("qa_stock","id='$p' AND vehicleNo='$v' AND date='$d'");
		
		/*
		 * deleting gradeStock table
		*/
		$this->db->delete("qa_gradeStock","id='$p' AND vehicleNo='$v' AND date='$d'");
		/*
		 * deleting sample table
		*/
		$this->db->delete("qa_sample","id='$p' AND vehicleNo='$v' AND date='$d'");
	
		/*
		 * deleting centerQuantity table
		*/
		$this->db->delete("qa_centerQuantity","id='$p' AND vehicleNo='$v' AND date='$d'");
	
		/*
		 * deleting center_fakes table
		*/
		$this->db->delete("qa_center_fakes","id='$p' AND vehicleNo='$v' AND date='$d'");
		/*
		 * deleting stockImages table
		*/
		//$db->delete("qa_stockImages","id='$p' AND vehicleNo='$v' AND date='$d'");
	
		/*
		 * deleting stockUpdates table
		*/
		$this->db->delete("qa_stockUpdates","areaId='$p' AND userId='".$_SESSION['SESS_MEMBER_ID']."' AND vehicleNo='$v' AND date='$d'");
	}
	
	
		
}



