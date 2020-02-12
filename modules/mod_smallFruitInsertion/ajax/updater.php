<?php
session_start();
require_once '../../../includes/HDatabase.php';
require_once '../../../libraries/base/project/lib_project.php';
require_once '../../../includes/Logger.php';

if($_POST['flag']){
	
	$headers = $_POST['headers'];
	$samples = $_POST['samples'];
	$crs = 	$_POST['crs'];
	$belongs = $_POST['belongs'];
	$tms = 	$_POST['tms'];
	
	$data = $_SESSION['edit.reference'];
	$preId = $data['p'];
	$preDate = $data['d'];
	$preVehicleNo = $data['v'];
	
	$updater = new Updater();
	$updater->backup($preId, $preVehicleNo, $preDate);
	$updater->setHeaders($headers);
	$updater->setSamples($samples);
	$updater->setCrs($crs);
	$updater->setBelongs($belongs);
	$updater->setTms($tms);
	header('Content-type:application/json');
	 
	if($updater->handle()){
		echo json_encode(array('success'=>true,'message'=>'Stock data updated successfully!'));
	}
	else{
		echo json_encode(array('success'=>false,'message'=>'Unable to update stock data. Previous stock data will be restored'));
	} 
}


class Updater{
	
	var $countes = 0;
	public static $keysSimple = array('sampleNo',
					                  'mellonFlyAttacked',
					                  'peeledOff',
					                  'boreAttacked',
					                  'shrivelled',
					                  'mechanicalDamaged',
					                  'yellowish',
					                  'rustPatches',
					                  'rotten',
					                  'totalDefects'
									);
	public static $keysExtended = array('sampleNo'=>0,
				                         'fruitCount'=>0,
				                         'largeFruit'=>0,
				                         'smallFruit'=>0,
				                         'mellonFlyAttacked'=>0,
				                         'peeledOff'=>0,
				                         'boreAttacked'=>0,
				                         'sandEmbedded'=>0,
				                         'shrivelled'=>0,
				                         'deformed'=>0,
				                         'virusAttacked'=>0,
				                         'mechanicalDamaged'=>0,
				                         'yellowish'=>0,
				                         'rustPatches'=>0,
				                         '45mm'=>0,
				                         'ac/re'=>0,
				                         'rotten'=>0,
				                         'total'=>0
									);
	
	
	private $db;
	private $store = array();
	private $refs = array();
	private $smallGrades = array('11-14','14-17','17-29','29-44','CRS');
	private $headers ;
	private $samples;
	private $crs;
	private $belongs;
	private $tms;
	private $cols =array(	'stockUpdates' => "`vehicleNo`,`userId`,`stationId`,`date`,`areaId`",
			
							'small_crop' => "`id`,`project`,`centers`,`date`,`batchNo`,`vehicleNo`,`itmNo`,`totalOffGrade`,`total_DQ`,`total_AQ`,`11-14Q`,
												`14-17Q`,`17-29Q`,`29-44Q`,`crs`,`rejected`,`hiddenLoss`,`weightLoss`,`transport-delivery`,
												`transport-cover`,`transport-smell`,`transport-otherThings`,`transport-labels`,
											`transport-QualityReport`,`noOfCrates`,`tmNumbers`",
			
							'small_belongs' => "`id`,`date`,`project`,`vehicleNo`,`gradeName`,`DQ`,`AQ`,`11-14`,`14-17`,`17-29`,`29-44`,`CRS`,
												`reject`,`hiddenLoss`,`weightLoss`,`offGrade`,`mode`,`afc`",
			
							'small_cropSampleGrades'=>"`id`,`date`,`gradeName`,`project`,`vehicleNo`,`sampleId`,`sampleNo`,`mellonFlyAttacked`",
												"`peeledOff`,`boreAttacked`,`shrivelled`,`mechanicalDamaged`,`yellowish`,`rustPatches`,`rottentotalDefects`",
							
							'small_cropSampleGrades2'=>"`id`,`date`,`gradeName`,`project`,`vehicleNo`,`sampleId`,`sampleNo`,`fruitCount`,
														`smallFruit`,`largeFruit`,`mellonFlyAttacked`,`peeledOff`,`boreAttacked`,`sandEmbedded`,
														`shrivelled`,`deformed`,`virusAttacked`,`mechanicalDamaged`,`yellowish`,`rustPatches`,`45mm`,`ac/re`,`rotten`,`total`",
							
							'small_cropSampleStat'=>"`id`,`date`,`vehicleNo`,`gradeName`,`fruitCount`,`smallFruit`,`largeFruit`,`mellonFlyAttacked`,`peeledOff`,
															`boreAttacked`,`sandEmbedded`,`shrivelled`,`deformed`,`virusAttacked`,`mechanicalDamaged`,`yellowish`,`rustPatches`,`45mm`,`ac/re`,`rotten`",
			
							'small_crsData' => "`id`,`project`,`date`,`vehicleNo`,`smallFruit`,`largeFruit`,`melonFlyAttacked`,`peeledOff`,`boreAttacked`,
												`sandEmbedded`,`shrivelled`,`mechanicalDamaged`,`yellowish`,`rustPatches`,`accepted`,`spoiled`",
			
							'small_crsSampleData' => "`id`,`project`,`date`,`vehicleNo`,`sampleId`,`fruitCount`,`smallFruit`,`largeFruit`,`melonFlyAttacked`,
												`peeledOff`,`boreAttacked`,`sandEmbedded`,`shrivelled`,`mechanicalDamaged`,`yellowish`,`rustPatches`,`accepted`,`spoiled`",
							
							'centerQuantitySmall' => "`id`,`project`,`date`,`vehicleNo`,`center`,`tmNo`,`grade1`,`grade2`,`grade3`,`grade4`,`grade5`",
							
							'stockUpdates_small'=>"`vehicleNo`,`userId`,`stationId`,`date`,`areaId`"
							
						);
	
	public function __construct(){
		$this->db = new HDatabase();
		$this->db->connect();
	}
	
	public function getGradeMode($name){	
		foreach ($this->samples as $sample){
			if($sample['name'] == $name){
				return $sample['mode'] == 'true'?true:false;
			}
		}
	}
	
	public function handle(){
		//
		$this->deleteStock($this->refs['id'],$this->refs['v'], $this->refs['d']);
		//inserting 
		//update stocks
		$this->db->startTransaction(); 
		 $crop = array($this->refs['id'],'',
						$this->headers['centers'],
						$this->headers['date'],
						$this->headers['batchNo'],
						$this->headers['vehicleNo'],
						$this->headers['itm'],
						$this->headers['totalOffgrade'],
						$this->headers['totalDQ'],	
						$this->headers['totalAQ'],
						$this->headers['11_14Q'],
						$this->headers['14_17Q'],
						$this->headers['17_29Q'],
						$this->headers['29_44Q'],
						$this->headers['crs'],
						$this->headers['reject'],
						$this->headers['hl'],
						$this->headers['wl'],
						$this->headers['delivery'],
						$this->headers['cover'],
						$this->headers['smell'],
						$this->headers['otherThings'],
						$this->headers['colorcode'],
						$this->headers['qr'],
						$this->headers['crates'],
						''
				);
		$tracker = true;
		if($this->db->insert('qa_small_crop', $crop)){
			
		}
		else{
			error_log(error_log('ERROR: qa_small_crop '.$this->db->getError()));
			$tracker = false;
		} 
		//belongs */
		
		foreach ($this->belongs as $belong){
			$id = $belong['id'];
			$data = $belong['d'];
			$offgrade = $belong['off'];
			$afc = isset($belong['afc'])?$belong['afc']:0;
			$mode = $this->getGradeMode($this->smallGrades[$id]);	
			$mode = $mode?'1':'0';		
			$b = array($this->refs['id'],
					$this->headers['date'],
					'',
					$this->headers['vehicleNo'],
					$this->smallGrades[$id],
					$data[0],$data[1],$data[2],$data[3],$data[4],$data[5],$data[6],$data[7],$data[8],$data[9],
					$offgrade,$mode,$afc
					);
			if($this->db->insert('qa_small_belongs', $b)){
				
			}
			else{
				error_log('ERROR: qa_small_belongs '.$this->db->getError());
				$tracker = false;
			} 
		}
		
		foreach ($this->samples as $grade){
			$headers =  array($this->refs['id'],$this->headers['date'],$grade['name'],'',$this->headers['vehicleNo']);
			$samples = $grade['samples'];
			$mode = $grade['mode'];
			foreach ($samples as $sample){
				$insert = array($this->refs['id'],
								$this->headers['date'],
								$grade['name'],
								'',
								$this->headers['vehicleNo'],
								$sample['id']
						);
				$insert = array_merge($headers,array($sample['id']),$sample['samples']);
			 	if($this->db->insert('qa_small_cropSampleGrades2', $insert)){
				}
				else{
					error_log('ERROR: qa_small_cropSampleGrades2'.$this->db->getError());
					$tracker = false;
				} 
			}
			//inserting stats 
			if($mode == 'true'){
				$pers = $grade['pers'];
				$sums = $grade['sums'];
				$merged = array();
				if(count($pers) == count($sums)){
					for($i=0; $i<count($pers);$i++){
						$merged[$i] = implode('-',array($sums[$i],$pers[$i]));
					}
					array_shift($merged);
					array_pop($merged);
				}
				$insert = array($this->refs['id'],$this->headers['date'],$this->headers['vehicleNo'],$grade['name']);
				$insert = array_merge($insert,$merged);
				if($this->db->insert('qa_small_cropSampleStat', $insert)){
				}
				else{
					error_log('ERROR: qa_small_cropSampleStat'.$this->db->getError());
					$tracker = false;
				}
				
			}
		}
		
		$crsSamples = $this->crs['samples'];
		$crsStat = $this->crs['stat'];
		foreach ($crsSamples as $sample){
			$id = $sample['id'];
			$data = $sample['s'];
			$crs = array($this->refs['id'],
						'',
					$this->headers['date'],
					$this->headers['vehicleNo'],
					$id,
					$data[0],$data[1],$data[2],$data[3],$data[4],$data[5],$data[6],$data[7],$data[8],$data[9],$data[10],$data[11],$data[12]
					);
			if($this->db->insert('qa_small_crsSampleData',$crs)){
			 		
			}
			else{
				error_log('ERROR: qa_small_crsSampleData '.$this->db->getError());
				$tracker = false;
			}
		} 
			$dataArray = array();
		 	foreach ($crsStat as $stat){
		 		array_push($dataArray, implode('-',$stat));
		 	}
			$insert = array($this->refs['id'],'',	$this->headers['date'],$this->headers['vehicleNo']);
			$insert = array_merge($insert,$dataArray);
			if($this->db->insert('qa_small_crsData', $insert)){
			}
			else{
				error_log('ERROR: qa_small_crsData '.$this->db->getError());
				$tracker = false;
			}
		//stock updates
			$station = $this->getStation($_SESSION['SESS_MEMBER_ID']);
			$insert = array(
					$this->headers['vehicleNo'],
					$_SESSION['SESS_MEMBER_ID'],
					$station['stationId'],
					$this->headers['date'],
					$this->refs['id']);
			if($this->db->insert('qa_stockUpdates_small',$insert)){
			}
			else{
				error_log('ERROR: qa_stockUpdates_small '.$this->db->getError());
				$tracker = false;
			}
			//center qs
			$preArray = array($this->refs['id'],'',$this->headers['date'],$this->headers['vehicleNo']);
			foreach ($this->tms as $tm){
				
				$temp = array($tm['center'],$tm['tm'],$tm['g1'],$tm['g2'],$tm['g3'],$tm['g4'],$tm['g5']);
				$insert = array_merge($preArray,$temp);
				if($this->db->insert('qa_centerQuantitySmall', $insert)){
				}
				else{
					error_log('ERROR: qa_centerQuantitySmall '.$this->db->getError());
					$tracker = false;
				}
			}
			
			if($tracker){
				error_log('DONE : Commiting the transaction');
				$this->db->commitTransaction();
				return true;
					
			}else{
				error_log('ERROR : Rollbacking the transaction');
				$this->db->rollbackTransaction();
				$this->deleteStock($this->refs['id'], $this->headers['vehicleNo'],$this->headers['date']);
				$this->restore();
			}
	}
	
	private function getStation($user){
		
		$this->db->resetResult();
		$this->db->select('qa_station','*',"inchargePersonId='{$user}'");
		$res = $this->db->getResult();
		return array_pop($res);
	}

	public function setHeaders($h){
		$this->headers = $h;
	}
	
	public function setSamples($s){
		$this->samples = $s;
	}
	
	public function setCrs($cr){
		$this->crs = $cr;
	}
	
	public function setBelongs($b){
		$this->belongs = $b;
	}
	
	public function setTms($tm){
		$this->tms = $tm;
	}
	
	public function backup($p,$v,$d){
		$user = $_SESSION['SESS_MEMBER_ID'];
		$this->refs['id'] = $p;
		$this->refs['v'] = $v;
		$this->refs['d'] = $d;
		
		$this->db->resetResult();
		$this->db->select('qa_stockUpdates_small',"*","userId='{$user}' AND date='{$d}' AND vehicleNo='{$v}' AND areaId='{$p}'");
		$updates = $this->db->getResult();
		$updates = array_pop($updates);
		$this->store['updates'] = $updates;
		
		$this->db->resetResult();
		$this->db->select('qa_small_crop',"*","id='{$p}' AND date='{$d}' AND vehicleNo='{$v}'");
		$crop = $this->db->getResult();
		$crop = array_pop($crop) ;
		$this->store['crop'] = $crop;
		
		$this->db->resetResult();
		$this->db->select('qa_small_belongs',"*","id='{$p}' AND date='{$d}' AND vehicleNo='{$v}'");
		$belongs = $this->db->getResult();
		$this->store['belongs'] = $belongs;
		
		$this->db->resetResult();
		$this->db->select('qa_small_cropSampleGrades2',"*","id='{$p}' AND date='{$d}' AND vehicleNo='{$v}'");
		$samples = $this->db->getResult();
		$this->store['samples'] = $samples;
		
		$this->db->resetResult();
		$this->db->select('qa_small_cropSampleStat',"*","id='{$p}' AND date='{$d}' AND vehicleNo='{$v}'");
		$sampleStat = $this->db->getResult();
		$this->store['sampleStat'] = $sampleStat;
		
		$this->db->resetResult();
		$this->db->select('qa_small_crsData',"*","id='{$p}' AND date='{$d}' AND vehicleNo='{$v}'");
		$crsStat = $this->db->getResult();
		$this->store['crsStat'] = $crsStat;
		
		$this->db->resetResult();
		$this->db->select('qa_small_crsSampleData',"*","id='{$p}' AND date='{$d}' AND vehicleNo='{$v}'");
		$crsSample = $this->db->getResult();
		$this->store['crsSample'] = $crsSample;
		
		$this->db->resetResult();
		$this->db->select('qa_centerQuantitySmall',"*","id='{$p}' AND date='{$d}' AND vehicleNo='{$v}'");
		$tms = $this->db->getResult();
		$this->store['tms'] = $tms;
	}
	
	public function restore(){
		if(!empty($this->refs)){
			error_log('Going to restore the stock');
			$tracker = true;
			$this->db->startTransaction();
			$this->countes++;
			if($this->db->insert('qa_stockUpdates_small',array_values($this->store['updates']),$this->cols['stockUpdates_small'])){
			}
			else{
				$tracker = false;
			}
			
			if($tracker && $this->db->insert('qa_small_crop',array_values($this->store['crop']),$this->cols['small_crop'])){
			}
			else{
				$tracker = false;
			}
			
			if($tracker){
				foreach ($this->store['belongs'] as $temp){
					
					if($this->db->insert('qa_small_belongs',array_values($temp),$this->cols['small_belongs'])){
					
					}
					else{
						$tracker = false;
					}
				}
			}
			
			if($tracker){
				foreach ($this->store['samples'] as $temp){
					if($this->db->insert('qa_small_cropSampleGrades2', array_values($temp),$this->cols['small_cropSampleGrades2'])){
					}
					else{
						$tracker = false;
					}
				}
			}
			if($tracker){
				foreach ($this->store['sampleStat'] as $temp){
					if($this->db->insert('qa_small_cropSampleStat', array_values($temp),$this->cols['small_cropSampleStat'])){
					}
					else{
						$tracker = false;
					}
				}
			}
			
			if($tracker){
				foreach ($this->store['crsStat'] as $temp){
					if($this->db->insert('qa_small_crsData', array_values($temp),$this->cols['small_crsData'])){
					}
					else{
						$tracker = false;
					}
				}
			}
			if($tracker){
				foreach ($this->store['crsSample'] as $temp){
					if($this->db->insert('qa_small_crsSampleData', array_values($temp),$this->cols['small_crsSampleData'])){
					}
					else{
						$tracker = false;
					}
				}
			}
			if($tracker){
				foreach ($this->store['tms'] as $temp){
					if($this->db->insert('qa_centerQuantitySmall', array_values($temp),$this->cols['centerQuantitySmall'])){
					}
					else{
						$tracker = false;
					}
				}
			}
			//commit the transaction
			if($tracker){
				error_log('DONE: Restored. committing. ');
				$this->db->commitTransaction();
			}else{
				error_log('ERROR: in restoring. gonna roll back ');
				$this->db->rollbackTransaction();
			}
			
		}
		else{
			throw new Exception('References are not set. cannot do the restoration');	
		}
	}
	public	function deleteStock($p,$v,$d){
		
		$this->db->delete("qa_small_crop","id='$p' AND vehicleNo='$v' AND date='$d'");
		
		$this->db->delete("qa_small_belongs","id='$p' AND vehicleNo='$v' AND date='$d'");
		
		$this->db->delete("qa_small_cropSampleGrades2","id='$p' AND vehicleNo='$v' AND date='$d'");
		
		$this->db->delete("qa_small_cropSampleStat","id='$p' AND vehicleNo='$v' AND date='$d'");
		
		$this->db->delete("qa_small_crsData","id='$p' AND vehicleNo='$v' AND date='$d'");
		
		$this->db->delete("qa_small_crsSampleData","id='$p' AND vehicleNo='$v' AND date='$d'");
		
		$this->db->delete("qa_stockImagesSmall","id='$p' AND vehicleNo='$v' AND date='$d'");
		
		$this->db->delete("qa_centerQuantitySmall","id='$p' AND vehicleNo='$v' AND date='$d'");
		
		$this->db->delete("qa_stockUpdates_small","areaId='$p' AND vehicleNo='$v' AND date='$d' AND userId='".$_SESSION['SESS_MEMBER_ID']."'");

		$this->db->delete("qa_confirmed_stocks","id='$p' AND vehicleNo='$v' AND date='$d'");
	
	}
	
}
?>