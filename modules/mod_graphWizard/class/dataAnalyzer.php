<?php

class analyzer{
	private $db;
	public  $decraledQuantity;
	public  $ActualQuantity;
	public  $payableQuantity;

	public $offGrade;
	public $majorDefects;
	public $minorDefects;

	public $suppliers = array(array());
	public $supplierAreas = array();
	public $supplierStocks;
	public $supplierAqs;
	public $stocks;
	public $defectAverages = array();

	public function analyzer(){
		$this->db=new HDatabase();
		$this->db->connect();
	}

	public function setQuantitySum($stationId,$date){
		$this->decraledQuantity[$stationId] = 0;
		$this->ActualQuantity[$stationId] = 0;
		$this->payableQuantity[$stationId] = 0;

		$date_f = $date." 00:00:00";
		$date_l = $date." 23:59:59";
		$this->offGrade[$stationId] = 0;
		$this->majorDefects[$stationId] = 0;
		$this->minorDefects[$stationId] = 0;
		$dbo = $this->db;
		$stocks = array();
		$dbo->select('qa_stockUpdates','vehicleNo,date',"stationId='$stationId' AND date>='$date_f' AND date<='$date_l'");
		$s = $dbo->getResult();
		$i = 0;
		if(isset($s)){
			foreach ($s as $temp){
				$stocks[$i]['vehicleNo'] = $temp['vehicleNo'];
				$stocks[$i]['date'] = $temp['date'];
				$i++;
			}
		}

		$stock_for_day;
		$dbo->resetResult();
		for($j=0;$j<count($stocks);$j++){
				
			$dbo->select('qa_gradeStock','notedWeight,trueWeight,payableQuantity',"vehicleNo='".$stocks[$j]['vehicleNo']."' AND date='".$stocks[$j]['date']."'");
			$res_1 = $dbo->getResult();
			if(isset($res_1)){
				$stock_for_day[$j] = $res_1;
				$dbo->resetResult();
			}
		}
		/*Set the array to stocks seperately*/
		if(isset($stock_for_day)){
			for($k=0;$k<count($stock_for_day);$k++){
				foreach ($stock_for_day[$k] as $temp){
					$this->decraledQuantity[$stationId] += $temp['notedWeight'];
					$this->ActualQuantity[$stationId] += $temp['trueWeight'];
					$this->payableQuantity[$stationId] += $temp['payableQuantity'];
				}
			}
		}
		/*appending Small Stocks*/
		$this->setSmallPercentageByStation($stationId, $date);
	}

	function resetQuntities(){
		$this->ActualQuantity = null;
		$this->decraledQuantity = null;
		$this->payableQuantity = null;
	}

	public function setSupplierArraysNew($date){
		$date_f = $date." 00:00:00";
		$date_l = $date." 23:59:59";
		$this->db->resetResult();
		$dbo = $this->db;
		$currentSeason = Season::getPresentSeason();
		$dbo->select('qa_area','DISTINCT userId',"cate_id!='5' AND season=".$currentSeason->getSeasonId());
		$result = $dbo->getResult();

		foreach ($result as $pos => $temp) {
			$this->suppliers[$pos] = $temp['userId'];
		}

		for($i = 0;$i<count($this->suppliers);$i++) {
			$dbo->resetResult();
			$dbo->select('qa_area','areaId,areaName',"userId='".$this->suppliers[$i]."'");
			$res = $dbo->getResult();
			for($j=0;$j<count($res);$j++){
				$this->supplierAreas[$i][$j] = $res[$j]['areaId'];
			}
			$dbo->resetResult();
		}

	 	for($a=0;$a<count($this->supplierAreas);$a++){
			$this->defectAverages[$a]['offGrade'] = 0;
			$this->defectAverages[$a]['majorDefects'] = 0;
			$this->defectAverages[$a]['minorDefects'] = 0;
		}
		 
		$suppler_stocks = array();
		//[supplier][project][stock][grade]
		$db = HDatabase::getInstance();

		for($k = 0; $k<count($this->supplierAreas); $k++){
			$proj_tracker = 0;
			for($l = 0;$l<count($this->supplierAreas[$k]);$l++){
				$db->resetResult();
				$db->select("qa_stock","id,areaId,date,vehicleNo","id='".$this->supplierAreas[$k][$l]."' and date>='$date_f' and date<='$date_l'");
				$result_stock = $db->getResult();
				 
				if($result_stock){
					
				for($m = 0;$m<count($result_stock);$m++){

					$db->resetResult();
					$db->select('qa_gradeStock','id,project,gradeId,vehicleNo,date,notedWeight,trueWeight,payableQuantity,averageFruitCount,sumOfSmallFruit,
    							sumOfLargeFruit,sumOfFlyAttacked,sumOfPeeledOff,sumOfBoreAttacked,
    			              	sumOfSandEmbedded,sumOfShrivelled,sumOfDeformed,sumOfVirusAttacked,sumOfMechanicalDamaged,sumOfYellowish,sumOfRustPatches,sumOf45,
    			             	sumOfRotten',"id='".$result_stock[$m]['id']."' AND date='".$result_stock[$m]['date']."' AND vehicleNo='".$result_stock[$m]['vehicleNo']."'");	
					 
					$result_gradeStock = $db->getResult();

					for($n=0;$n<count($result_gradeStock);$n++){

						$averageFC = $result_gradeStock[$n]['averageFruitCount'];
						$grade = $result_gradeStock[$n]['gradeId'];
						$samppleWeight = $this->getGradeSampleWeight($grade);

						$numOfSamples = $this->getNumOfSamples($result_gradeStock[$n]['id'], $result_gradeStock[$n]['vehicleNo'], $result_gradeStock[$n]['date'], $result_gradeStock[$n]['gradeId']);
							
						if($numOfSamples>0){
							$divider = $averageFC*$samppleWeight*$numOfSamples;
								
							$per_small = ($result_gradeStock[$n]['sumOfSmallFruit']/$divider)*100;
							$per_small = round($per_small,2);
								
							$per_large = ($result_gradeStock[$n]['sumOfLargeFruit']/$divider)*100;
							$per_large = round($per_large,2);
								
							$per_flyAttack = ($result_gradeStock[$n]['sumOfFlyAttacked']/$divider)*100;
							$per_flyAttack = round($per_flyAttack,2);
								
							$per_peeledOff = ($result_gradeStock[$n]['sumOfPeeledOff']/$divider)*100;
							$per_peeledOff = round($per_peeledOff,2);
								
							$per_boreAttack = ($result_gradeStock[$n]['sumOfBoreAttacked']/$divider)*100;
							$per_boreAttack = round($per_boreAttack,2);
								
							$per_sandEmbedded = ($result_gradeStock[$n]['sumOfSandEmbedded']/$divider)*100;
							$per_sandEmbedded = round($per_sandEmbedded,2);
								
							$per_shrivelled = ($result_gradeStock[$n]['sumOfShrivelled']/$divider)*100;
							$per_shrivelled = round($per_shrivelled,2);
								
							$per_deform = ($result_gradeStock[$n]['sumOfDeformed']/$divider)*100;
							$per_deform = round($per_deform,2);
								
							$per_virusAttack = ($result_gradeStock[$n]['sumOfVirusAttacked']/$divider)*100;
							$per_virusAttack = round($per_virusAttack,2);
								
							$per_mechDamage = ($result_gradeStock[$n]['sumOfMechanicalDamaged']/$divider)*100;
							$per_mechDamage = round($per_mechDamage,2);
								
							$per_yellowish = ($result_gradeStock[$n]['sumOfYellowish']/$divider)*100;
							$per_yellowish = round($per_yellowish,2);
								
							$per_rustPatches = ($result_gradeStock[$n]['sumOfRustPatches']/$divider)*100;
							$per_rustPatches = round($per_rustPatches,2);
								
							$per_45 = ($result_gradeStock[$n]['sumOf45']/$divider)*100;
							$per_45 = round($per_45,2);

							$suppler_stocks[$k][$l][$m][$n]['offGrade'] = $per_small+$per_large;
							$suppler_stocks[$k][$l][$m][$n]['majorDefects'] = $per_flyAttack+$per_peeledOff+$per_boreAttack+$per_sandEmbedded+$per_shrivelled;
							$suppler_stocks[$k][$l][$m][$n]['minorDefects'] = $per_deform+$per_virusAttack+$per_mechDamage+$per_yellowish+$per_rustPatches+$per_45;
								
						}
					}
					//settting averages of grades of a stock
					$suppler_stocks[$k][$l][$m]['offGrade'] = 0;
					$suppler_stocks[$k][$l][$m]['majorDefects'] = 0;
					$suppler_stocks[$k][$l][$m]['minorDefects'] = 0;
					for($p=0;$p<$n;$p++){
						$suppler_stocks[$k][$l][$m]['offGrade'] += $suppler_stocks[$k][$l][$m][$p]['offGrade'];
						$suppler_stocks[$k][$l][$m]['majorDefects'] += $suppler_stocks[$k][$l][$m][$p]['majorDefects'];
						$suppler_stocks[$k][$l][$m]['minorDefects'] += $suppler_stocks[$k][$l][$m][$p]['minorDefects'];
					}
					$suppler_stocks[$k][$l][$m]['offGrade'] = round($suppler_stocks[$k][$l][$m]['offGrade']/$n,2);
					$suppler_stocks[$k][$l][$m]['majorDefects'] = round($suppler_stocks[$k][$l][$m]['majorDefects']/$n,2);
					$suppler_stocks[$k][$l][$m]['minorDefects'] = round($suppler_stocks[$k][$l][$m]['minorDefects']/$n,2);
					}
					$proj_tracker++;
				}
				$suppler_stocks[$k][$l]['offGrade']=0;
				$suppler_stocks[$k][$l]['majorDefects']=0;
				$suppler_stocks[$k][$l]['minorDefects']=0;
				 
				for($q=0;$q<$m;$q++){
					$suppler_stocks[$k][$l]['offGrade']+=$suppler_stocks[$k][$l][$q]['offGrade'];
					$suppler_stocks[$k][$l]['majorDefects']+=$suppler_stocks[$k][$l][$q]['majorDefects'];
					$suppler_stocks[$k][$l]['minorDefects']+=$suppler_stocks[$k][$l][$q]['minorDefects'];
				}
				$suppler_stocks[$k][$l]['offGrade']=round($suppler_stocks[$k][$l]['offGrade']/$m,2);
				$suppler_stocks[$k][$l]['majorDefects']=round($suppler_stocks[$k][$l]['majorDefects']/$m,2);
				$suppler_stocks[$k][$l]['minorDefects']=round($suppler_stocks[$k][$l]['minorDefects']/$m,2);
			}
			$suppler_stocks[$k]['offGrade']=0;
			$suppler_stocks[$k]['majorDefects']=0;
			$suppler_stocks[$k]['minorDefects']=0;
			for($r=0;$r<$l;$r++){
				$suppler_stocks[$k]['offGrade']+=$suppler_stocks[$k][$r]['offGrade'];
				$suppler_stocks[$k]['majorDefects']+=$suppler_stocks[$k][$r]['majorDefects'];
				$suppler_stocks[$k]['minorDefects']+=$suppler_stocks[$k][$r]['minorDefects'];
			}
			$suppler_stocks[$k]['offGrade']=round($suppler_stocks[$k]['offGrade']/$proj_tracker,2);
			$suppler_stocks[$k]['majorDefects']=round($suppler_stocks[$k]['majorDefects']/$proj_tracker,2);
			$suppler_stocks[$k]['minorDefects']=round($suppler_stocks[$k]['minorDefects']/$proj_tracker,2);
		}
		return $suppler_stocks;
	}

	public function setSupplierArray($date){
		$date_f=$date." 00:00:00";
		$date_l=$date." 23:59:59";
		$this->db->resetResult();
		$dbo=$this->db;
		//select large & small suppliers
		$dbo->select('qa_area','DISTINCT userId',"cate_id!=5");
		$result=$dbo->getResult();
		$i=0;
		foreach ($result as $temp){
			$this->suppliers[$i]=$temp['userId'];
			$i++;
		}
		$dbo->resetResult();
		for($i=0;$i<count($this->suppliers);$i++){
			$dbo->select('qa_area','areaId,areaName',"userId='".$this->suppliers[$i]."'");
			$res=$dbo->getResult();
			for($j=0;$j<count($res);$j++){
				$this->supplierAreas[$i][$j]=$res[$j]['areaId'];
			}
			$dbo->resetResult();
		}
		 
		for($a=0;$a<count($this->supplierAreas);$a++){
			$this->defectAverages[$a]['offGrade']=0;
			$this->defectAverages[$a]['majorDefects']=0;
			$this->defectAverages[$a]['minorDefects']=0;
		}
		 
		for($i=0;$i<count($this->supplierAreas);$i++){
			$k=0;
			for($j=0;$j<count($this->supplierAreas[$i]);$j++){
				$dbo->resetResult();
				$dbo->select('qa_gradeStock','project,gradeId,vehicleNo,date,notedWeight,trueWeight,payableQuantity,averageFruitCount,sumOfSmallFruit,sumOfLargeFruit,sumOfFlyAttacked,sumOfPeeledOff,sumOfBoreAttacked,
    			              sumOfSandEmbedded,sumOfShrivelled,sumOfDeformed,sumOfVirusAttacked,sumOfMechanicalDamaged,sumOfYellowish,sumOfRustPatches,sumOf45,sumOfRotten',"id='".$this->supplierAreas[$i][$j]."' AND date>='$date_f' AND date<='$date_l'");	
				 
				$result_temp=$dbo->getResult();
				$this->supplierStocks[$i][$j]['notedWeight']=0;
				$this->supplierStocks[$i][$j]['trueWeight']=0;
				$this->supplierStocks[$i][$j]['payableQuantity']=0;
				$this->supplierStocks[$i][$j]['offGrade']=0;
				$this->supplierStocks[$i][$j]['majorDefects']=0;
				$this->supplierStocks[$i][$j]['minorDefects']=0;
				 
				if(isset($result_temp)){
					$m=0;
					foreach ($result_temp as $t) {

						$this->supplierStocks[$i][$j]['notedWeight']+=$t['notedWeight'];
						$this->supplierStocks[$i][$j]['trueWeight']+=$t['trueWeight'];
						$this->supplierStocks[$i][$j]['payableQuantity']+=$t['payableQuantity'];
						/*in here percentages should be calculated*/

						$averageFC=$t['averageFruitCount'];
						$grade=$t['gradeId'];
						$samppleWeight=$this->getGradeSampleWeight($grade);

						$numOfSamples=$this->getNumOfSamples($t['project'], $t['vehicleNo'], $t['date'], $t['gradeId']);
						if($numOfSamples>0){
							$divider=$averageFC*$samppleWeight*$numOfSamples;
								
							$per_small=($t['sumOfSmallFruit']/$divider)*100;
							$per_small=round($per_small,2);
								
							$per_large=($t['sumOfLargeFruit']/$divider)*100;
							$per_large=round($per_large,2);
								
							$per_flyAttack=($t['sumOfFlyAttacked']/$divider)*100;
							$per_flyAttack=round($per_flyAttack,2);
								
							$per_peeledOff=($t['sumOfPeeledOff']/$divider)*100;
							$per_peeledOff=round($per_peeledOff,2);
								
							$per_boreAttack=($t['sumOfBoreAttacked']/$divider)*100;
							$per_boreAttack=round($per_boreAttack,2);
								
							$per_sandEmbedded=($t['sumOfSandEmbedded']/$divider)*100;
							$per_sandEmbedded=round($per_sandEmbedded,2);
								
							$per_shrivelled=($t['sumOfShrivelled']/$divider)*100;
							$per_shrivelled=round($per_shrivelled,2);
								
							$per_deform=($t['sumOfDeformed']/$divider)*100;
							$per_deform=round($per_deform,2);
								
							$per_virusAttack=($t['sumOfVirusAttacked']/$divider)*100;
							$per_virusAttack=round($per_virusAttack,2);
								
							$per_mechDamage=($t['sumOfMechanicalDamaged']/$divider)*100;
							$per_mechDamage=round($per_mechDamage,2);
								
							$per_yellowish=($t['sumOfYellowish']/$divider)*100;
							$per_yellowish=round($per_yellowish,2);
								
							$per_rustPatches=($t['sumOfRustPatches']/$divider)*100;
							$per_rustPatches=round($per_rustPatches,2);
								
							$per_45=($t['sumOf45']/$divider)*100;
							$per_45=round($per_45,2);

							$this->supplierStocks[$i][$j]['offGrade']+=$per_small+$per_large;
							$this->supplierStocks[$i][$j]['majorDefects']+=$per_flyAttack+$per_peeledOff+$per_boreAttack+$per_sandEmbedded+$per_shrivelled;
							$this->supplierStocks[$i][$j]['minorDefects']+=$per_deform+$per_virusAttack+$per_mechDamage+$per_yellowish+$per_rustPatches+$per_45;
						}
						$m++;
					}
					/*getting gradewise average*/
					if($this->supplierStocks[$i][$j]['offGrade']){
							
						$this->supplierStocks[$i][$j]['offGrade']=round($this->supplierStocks[$i][$j]['offGrade']/$m,2);
					}

					if($this->supplierStocks[$i][$j]['majorDefects']){

						$this->supplierStocks[$i][$j]['majorDefects']=round($this->supplierStocks[$i][$j]['majorDefects']/$m,2);
					}

					if($this->supplierStocks[$i][$j]['minorDefects']){

						$this->supplierStocks[$i][$j]['minorDefects']=round($this->supplierStocks[$i][$j]['minorDefects']/$m,2);
					}
				}
				$dbo->resetResult();
				$k++;
			}
		}

		for($i=0;$i<count($this->supplierStocks);$i++){
			$this->stocks[$i]['notedWeight']=0;
			$this->stocks[$i]['trueWeight']=0;
			$this->stocks[$i]['payableQuantity']=0;

			$this->stocks[$i]['offGrade']=0;
			$this->stocks[$i]['majorDefects']=0;
			$this->stocks[$i]['minorDefects']=0;

			for($j=0; $j<count($this->supplierStocks[$i]);$j++){
				$this->stocks[$i]['notedWeight']+=$this->supplierStocks[$i][$j]['notedWeight'];
				$this->stocks[$i]['trueWeight']+=$this->supplierStocks[$i][$j]['trueWeight'];
				$this->stocks[$i]['payableQuantity']+=$this->supplierStocks[$i][$j]['payableQuantity'];

				$this->stocks[$i]['offGrade']+=$this->supplierStocks[$i][$j]['offGrade'];
				$this->stocks[$i]['majorDefects']+=$this->supplierStocks[$i][$j]['majorDefects'];
				$this->stocks[$i]['minorDefects']+=$this->supplierStocks[$i][$j]['minorDefects'];
			}
		}
	}

	public function getAveragedDefects(){
		$def=array();
		//getting the stock
		$stock=$this->supplierStocks;
		 
		for($i=0;$i<count($stock);$i++){
			$def[$i]['offGrade']=0;
			$def[$i]['majorDefects']=0;
			$def[$i]['minorDefects']=0;
		}
		$i=0;
		foreach ($stock as $temp){
			$k=0;
			foreach ($temp as $t){
				$def[$i]['offGrade']+=$t['offGrade'];
				$def[$i]['majorDefects']+=$t['majorDefects'];
				$def[$i]['minorDefects']+=$t['minorDefects'];
				$k++;
			}
			$def[$i]['offGrade']=round($def[$i]['offGrade']/$k,2);
			$def[$i]['majorDefects']=round($def[$i]['majorDefects']/$k,2);
			$def[$i]['minorDefects']=round($def[$i]['minorDefects']/$k,2);
			$i++;
		}
		return $def;
	}

	public function getSuppliersLM(){
		$names=array();
		$sups=$this->suppliers;
		 
		$user=new Huser();
		if(isset($sups)){
			for($i=0;$i<count($sups);$i++){
				$names[$i]=$user->getNameById($sups[$i]);
			}
			return $names;
		}else return false;
	}

	private function  getGradeSampleWeight($gradeId){
		$db=new HDatabase();
		$db->connect();
		$db->select("qa_grade","sampleWeight","gradeId='$gradeId'");
		$res=$db->getResult();

		if($res){
			return $res[0]['sampleWeight'];
				
		}else{
				
			return false;
		}
	}

	private function getNumOfSamples($p,$v,$d,$g){

		$db=new HDatabase();
		$db->connect();
		$db->select("qa_sample","*","id='$p' AND vehicleNo='$v' AND gradeId='$g' AND date='$d'");
		$res=$db->getResult();
		return $res ? count($res) : 0;
	}

	function setTotalQuantity($date){
		$suppliers;
		$season=$this->getOngoingSeason();
		$startDate=$season['startDate'];
		$endDate=$season['endDate'];
		$startDate.=" 00:00:00";
		$endDate.=" 23:59:59";
		$dbo=new HDatabase();
		$dbo->connect();
		 
		for($i=0;$i<count($this->supplierAreas);$i++){
			$this->supplierAqs[$i]=0;
			for($j=0;$j<count($this->supplierAreas[$i]);$j++){

				$dbo->select('qa_gradeStock','id,project,date,trueWeight',"id='".$this->supplierAreas[$i][$j]."' AND date>'$startDate' AND date<'$endDate'");
				$result_temp=$dbo->getResult();
				if(isset($result_temp)){
					foreach ($result_temp as $temp){
						$this->supplierAqs[$i]+=$temp['trueWeight'];
					}
				}
				$dbo->resetResult();
			}
		}
	}

	public  function getOngoingSeason(){
		$db=new HDatabase();
		$db->connect();
		$db->select('qa_seasons','seasonId,startDate,endDate',"flag='1'");
		$res=$db->getResult();
		$ret_array=array('id'=>$res[0]['seasonId'],'startDate'=>$res[0]['startDate'],'endDate'=>$res[0]['endDate']);
		return $ret_array;
	}

	public function getStockSumsSmall(){
		$smallSuppliers=$this->getSmallSuppliersArray();
		$d= mktime(0, 0, 0, date("m"), date("d")-1, date("y"));
		$this->date=date("Y-m-d", $d);
		$supplierStocks=array();
		$DBO=$this->db;
		$date=date("Y-m-d", $d);
		$date_f=$date." 00:00:00";
		$date_l=$date." 23:59:59";
		for($i=0;$i<count($smallSuppliers);$i++){
			//go through each supplier
			$supplierStocks[$i]['AQ']=0;
			$supplierStocks[$i]['DQ']=0;
			$supplierStocks[$i]['PQ']=0;
			$supplierStocks[$i]['11-14']=0;
			$supplierStocks[$i]['14-17']=0;
			$supplierStocks[$i]['17-29']=0;
			$supplierStocks[$i]['29-44']=0;
			$supplierStocks[$i]['CRS']=0;
			$supplierStocks[$i]['supplier']=$smallSuppliers[$i]['inchargeName'];
			for($j=0;$j<count($smallSuppliers[$i]['areas']);$j++){
				//query for each supplier area
				$DBO->select('qa_small_crop','*',"id='".$smallSuppliers[$i]['areas'][$j]."' AND date>='$date_f' AND date<='$date_l'");
				$res=$DBO->getResult();
				$count=0;
				if(isset($res)){
					foreach ($res as $temp){

						$supplierStocks[$i]['AQ']+=$temp['total_AQ'];
						$supplierStocks[$i]['DQ']+=$temp['total_DQ'];
						$supplierStocks[$i]['PQ']+=$temp['11-14Q'];
						$supplierStocks[$i]['PQ']+=$temp['14-17Q'];
						$supplierStocks[$i]['PQ']+=$temp['17-29Q'];
						$supplierStocks[$i]['PQ']+=$temp['29-44Q'];
						$supplierStocks[$i]['PQ']+=$temp['crs'];
							
						/*finding pers*/
						if($temp['total_AQ']!=0){
							$per11_14=($temp['11-14Q']/$temp['total_AQ'])*100;
							$per11_14=round($per11_14,2);
							$supplierStocks[$i]['11-14']+=$per11_14;

							$per14_17=($temp['14-17Q']/$temp['total_AQ'])*100;
							$per14_17=round($per14_17,2);
							$supplierStocks[$i]['14-17']+=$per14_17;
							 
							$per17_29=($temp['17-29Q']/$temp['total_AQ'])*100;
							$per17_29=round($per17_29,2);
							$supplierStocks[$i]['17-29']+=$per17_29;
							 
							$per29_44=($temp['29-44Q']/$temp['total_AQ'])*100;
							$per29_44=round($per29_44,2);
							$supplierStocks[$i]['29-44']+=$per29_44;
							 
							$perCRS=($temp['crs']/$temp['total_AQ'])*100;
							$perCRS=round($perCRS,2);
							$supplierStocks[$i]['CRS']+=$perCRS;

						}
						$count++;
					}
				}
				if($count!=0){
					$supplierStocks[$i]['11-14']=round($supplierStocks[$i]['11-14']/$count,2);
					$supplierStocks[$i]['14-17']=round($supplierStocks[$i]['14-17']/$count,2);
					$supplierStocks[$i]['17-29']=round($supplierStocks[$i]['17-29']/$count,2);
					$supplierStocks[$i]['29-44']=round($supplierStocks[$i]['29-44']/$count,2);
					$supplierStocks[$i]['CRS']=round($supplierStocks[$i]['CRS']/$count,2);
				}
				$DBO->resetResult();
			}
		}
		return $supplierStocks;
	}

	function getSmallSuppliersArray(){
		$SmallSuppliers=array();

		$DBO=$this->db;
		$DBO->resetResult();
		$DBO->select('qa_area','DISTINCT inchargeName,userId',"cate_id='5'",'userId ASC');
		$res=$DBO->getResult();

		if(isset($res)){
			$i=0;
			foreach ($res as $temp){

				$SmallSuppliers[$i]['inchargeName']=$temp['inchargeName'];
				$SmallSuppliers[$i]['userId']=$temp['userId'];
				$i++;
			}
		}
		$DBO->resetResult();

		for($i=0;$i<count($SmallSuppliers);$i++){
			$incharge=$SmallSuppliers[$i]['userId'];
			$DBO->select('qa_area','areaId,areaName',"userId='$incharge'");
			$res2=$DBO->getResult();
			$areas=array();
			foreach ($res2 as $temp){
				array_push($areas, $temp['areaId']);
			}
			$SmallSuppliers[$i]['areas']=$areas;
			$DBO->resetResult();
		}
		return $SmallSuppliers;
	}

	public function getSmallSupplierName(){
		$smallSuppliers=$this->getSmallSuppliersArray();
		 
		$suppliers=array();
		 
		for($i=0;$i<count($smallSuppliers);$i++){
			$suppliers[$i]=$smallSuppliers[$i]['userId'];
		}
		return $suppliers;
	}
	public function getSmallSupplierFullName(){
		$names=array();
		$user=new Huser();
		$sups=$this->getSmallSupplierName();
		for($i=0;$i<count($sups);$i++){
			$names[$i]=$user->getNameById($sups[$i]);
		}
		return $names;
	}

	public function getSmallStockAQ(){
		$smallSuppliers=$this->getSmallSupplierName();
		 
		$smallSupplierAreas=array();
		$smallSupplierStocks=array();
		$season=$this->getOngoingSeason();
		 
		$startDate=$season['startDate'];
		$endDate=$season['endDate'];
		$startDate.=" 00:00:00";
		$endDate.=" 23:59:59";
		 
		$DBO=new HDatabase();
		$DBO->connect();
		for($i=0;$i<count($smallSuppliers);$i++){

			$DBO->select('qa_area','areaId',"userId='".$smallSuppliers[$i]."'");
			$res=$DBO->getResult();
			$j=0;
			foreach ($res as $temp){
				$smallSupplierAreas[$i][$j]=$temp['areaId'];
				$j++;
			}
			$DBO->resetResult();
		}
		 
		for($j=0;$j<count($smallSupplierAreas);$j++){
			$smallSupplierStocks[$j]=0;
			for($k=0;$k<count($smallSupplierAreas[$j]);$k++){
				$DBO->select('qa_small_crop','total_AQ',"id='".$smallSupplierAreas[$j][$k]."' AND date>='$startDate' AND date<='$endDate'");
				$res=$DBO->getResult();
				if(isset($res)){
					foreach ($res as $temp){
						$smallSupplierStocks[$j]+=$temp['total_AQ'];
					}
				}
				$DBO->resetResult();
			}
		}
		 
		return $smallSupplierStocks;
	}

	public function getSmallStocksAQPQDQ(){
		$smallSuppliers=$this->getSmallSupplierName();
	}

	public function setSmallPercentageByStation($stationId,$date){
		/*getting stock bases*/
		$stationIdExist=true;
		$DBO=new HDatabase();
		$DBO->connect();
		$smallStockBase=array();
		$date_f=$date." 00:00:00";
		$date_l=$date." 23:59:59";
		$DBO->select('qa_stockUpdates_small','*',"stationId='$stationId' AND date>='$date_f' AND date<='$date_l'");
		 
		$res=$DBO->getResult();
		if(isset($res)){
			$i=0;
			foreach ($res as $temp){
				$smallStockBase[$i]['vehicleNo']=$temp['vehicleNo'];
				$smallStockBase[$i]['date']=$temp['date'];
				$i++;
			}

		}else{
			$stationIdExist=false;
		}
		 
		$smallStocks=array();
		$DBO->resetResult();
		 
		$smallStocks[$stationId]['AQ']=0;
		$smallStocks[$stationId]['DQ']=0;
		$smallStocks[$stationId]['PQ']=0;
		for($j=0;$j<count($smallStockBase);$j++){

			$DBO->select('qa_small_crop','*',"vehicleNo='".$smallStockBase[$j]['vehicleNo']."' and date='".$smallStockBase[$j]['date']."'");
			$res=$DBO->getResult();
			if(isset($res)){
				foreach ($res as $temp){
					$smallStocks[$stationId]['AQ']+=$temp['total_AQ'];
					$smallStocks[$stationId]['DQ']+=$temp['total_DQ'];
					$smallStocks[$stationId]['PQ']+=$temp['11-14Q'];
					$smallStocks[$stationId]['PQ']+=$temp['14-17Q'];
					$smallStocks[$stationId]['PQ']+=$temp['17-29Q'];
					$smallStocks[$stationId]['PQ']+=$temp['29-44Q'];
					$smallStocks[$stationId]['PQ']+=$temp['crs'];
				}
			}
			else {
				$stationIdExist=false;
			}
			$DBO->resetResult();
		}
		/*don't know how to get PQ .so it is left in 0*/
		/*appendto l/m stocks*/
		$this->ActualQuantity[$stationId]+=$smallStocks[$stationId]['AQ'];
		$this->decraledQuantity[$stationId]+=$smallStocks[$stationId]['DQ'];
		$this->payableQuantity[$stationId]+=$smallStocks[$stationId]['PQ'];
	}
}

class TotalStockAnalyzer{
	private $date;
	private $db;
	private $stations=array(1,2,3);
	public function TotalStockAnalyzer(){

		$d= mktime(0, 0, 0, date("m"), date("d")-1, date("y"));
		$this->date=date("Y-m-d", $d);
		$this->db=new HDatabase();
		$this->db->connect();

	}
	public function getStocks(){
		$stocks=array();

		for($i=0;$i<count($this->stations);$i++){
			$stocks[$this->stations[$i]] = $this->getStockAllByStation($this->stations[$i]);
		}
		if($stocks){
			return $stocks;
		}
		else{
			return false;
		}
	}

	public function getStockAllByStation($stationId){

		$sum['dq']=0;
		$sum['aq']=0;
		$sum['pq']=0;

		$f_date=$this->date." 00:00:00";
		$l_date=$this->date." 23:59:59";

		$this->db->resetResult();
		$this->db->select("qa_stockUpdates u, qa_stock s, qa_gradeStock g",
							"DISTINCT g.gradeId, g.project, g.vehicleNo, g.date, g.notedWeight, g.trueWeight, g.payableQuantity",
							"u.date >=  '$f_date'
								AND u.date <=  '$l_date'
								AND u.stationId =  '$stationId'
								AND u.date = s.date
								AND u.vehicleNo = s.vehicleNo
								AND s.vehicleNo = g.vehicleNo
								AND s.id = g.id
								AND s.date = g.date");
		$res=$this->db->getResult();
		if($res){
			foreach ($res as $t){
				$sum['dq']+=$t['notedWeight'];
				$sum['aq']+=$t['trueWeight'];
				$sum['pq']+=$t['payableQuantity'];
			}
			
		}
		$this->db->resetResult();
		$this->db->select("qa_stockUpdates_small ss, qa_area a , qa_small_crop sc",
							"*",
							" ss.date >=  '$f_date'
								AND ss.date <=  '$l_date'
								AND ss.stationId ='$stationId'
								AND ss.vehicleNo = sc.vehicleNo
								AND ss.areaId = a.areaId
								AND a.areaId=sc.id
								AND ss.date = sc.date"
							);
		$res2=$this->db->getResult();
		
		if($res2){
			foreach ($res2 as $temps){
				
				$sum['dq']+=$temps['total_DQ'];
				$sum['aq']+=$temps['total_AQ'];
				$pq=$temps['11-14Q']+$temps['14-17Q']+$temps['17-29Q']+$temps['29-44Q']+$temps['crs'];
				$sum['pq']+=$pq;
				
			}	
		}

		if($res || $res2){
			return $sum;
		}else{
			return false;
		}

	}
}
?>