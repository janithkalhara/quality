<?php
require_once '../../includes/HDatabase.php';
require_once '../../libraries/base/project/lib_project.php';

new SetTable($_POST);

class SetTable{

	public $project;
	public $startDate ;
	public $endDate;
	public $newVehicleNo = "";
	public $newDate = "";
	public $mydate;
	public $myVehicleNo ;
	public $noOfCrates;
	public $noOfBags;
	public $resultArray = array();

	function SetTable(){
		$this->project = $_POST['project'];
		$this->startDate = $_POST['startDate']." 00:00:00";
		$this->endDate = $_POST['endDate']." 23:59:59";

		settype($this->noOfBags,"double");
		settype($this->noOfCrates,"double");
			
		$this->noOfBags = 0;
		$this->noOfCrates = 0;

		$myCon = new HDatabase();
		$myCon->connect();
		$myCon->select('qa_area','cate_id',"areaId='$this->project'");
		$grRes = $myCon->getResult();
		$gradeCat = $grRes[0]['cate_id'];

		if($gradeCat != "5"){

			$db = new HDatabase();
			$db->connect();
			$db->select('qa_gradeStock','project,vehicleNo,date,noOfCrates',"id='$this->project' AND date>='$this->startDate' AND date<='$this->endDate'","date ASC");
			$result = $db->getResult();

			$con = new HDatabase();
			$con->connect();

			$p = array();
			if($result){
				$i=0;
				foreach ($result as $r){
					$vehicleNo = $r['vehicleNo'];
					$date = $r['date'];			

					$con->resetResult();
					$con->select('qa_stockUpdates','stationId',"vehicleNo='$vehicleNo' AND date='$date'");
					$sRes = $con->getResult();
					$stationId = $sRes[0]['stationId'];

					$con->resetResult();
					$con->select('qa_station',"stationName","stationId='$stationId'");
					$sResNew = $con->getResult();
					$stationName = $sResNew[0]['stationName'];
					
					$pro = new Project();
					$proNameArr= $pro->getProjectNameById($this->project);
					$proName = $proNameArr['areaName'];

					if($this->newVehicleNo == $vehicleNo && $this->newDate == $date){

						$total = explode("/",$r['noOfCrates']);

						if($total[0]){
							$this->noOfBags += $total[0];

						}else{
							$this->noOfBags += 0;
						}
						if(count($total)==2){
							$this->noOfCrates += $total[1];

						}else{
							$this->noOfCrates += 0;
						}
						$k=1;
					}else{
						if($this->noOfBags!= 0 || $this->noOfCrates!= 0){
							//print $this->noOfBags."-";
							//print $this->noOfCrates.":";

							array_push($p,$proName);
							array_push($p,$this->newDate);
							array_push($p,$this->newVehicleNo);
							array_push($p,$stationName);
							array_push($p,$this->noOfBags);
							array_push($p,$this->noOfCrates);
							$this->resultArray[$i]=$p;
							$p=array();
							$i++;
							$j=0;
						}

						$total = explode("/",$r['noOfCrates']);
						//print_r($total);
						if($total[0]){
							$this->noOfBags = $total[0];
						}else{
							$this->noOfBags = 0;
						}
						if(count($total)==2){
							$this->noOfCrates = $total[1];
						}else{
							$this->noOfCrates = 0;
						}

						$this->newVehicleNo = $r['vehicleNo'];
						$this->newDate = $r['date'];

						$k=1; $j=1;
					}

				}

				if($k=1 && $j=1){
					//print $this->noOfBags."-";
					//print $this->noOfCrates.":";

					array_push($p,$proName);
					array_push($p,$this->newDate);
					array_push($p,$this->newVehicleNo);
					array_push($p,$stationName);
					array_push($p,$this->noOfBags);
					array_push($p,$this->noOfCrates);
					$this->resultArray[$i]=$p;

				}

				print json_encode($this->resultArray);
			}else{
				print "0";
			}

		}// end of checking Small
		else{
			$db = new HDatabase();
			$db->connect();
			$db->select('qa_small_crop','project,vehicleNo,date,noOfCrates',"id='$this->project' AND date>='$this->startDate' AND date<='$this->endDate'","date ASC");
			$result = $db->getResult();
			
			$con = new HDatabase();
			$con->connect();

			if($result){
				$i=0;
				foreach ($result as $r){
					$vehicleNo = $r['vehicleNo'];
					$date = $r['date'];

					$con->resetResult();
					$con->select('qa_stockUpdates_small','stationId',"vehicleNo='$vehicleNo' AND date='$date'");
					$sRes = $con->getResult();
					$stationId = $sRes[0]['stationId'];

					$con->resetResult();
					$con->select('qa_station',"stationName","stationId='$stationId'");
					$sResNew = $con->getResult();
					$stationName = $sResNew[0]['stationName'];
					
					$pro = new Project();
					$proNameArr= $pro->getProjectNameById($this->project);
					$proName = $proNameArr['areaName'];

					$total = explode("/",$r['noOfCrates']);

					if($total[0]){
						$this->noOfBags = $total[0];
					}else{
						$this->noOfBags = 0;
					}
					if(count($total)==2){
						$this->noOfCrates = $total[1];
					}else{
						$this->noOfCrates = 0;
					}
						
					$p= array();
					array_push($p,$proName);
					array_push($p,$r['date']);
					array_push($p,$r['vehicleNo']);
					array_push($p,$stationName);
					array_push($p,$this->noOfBags);
					array_push($p,$this->noOfCrates);
					$this->resultArray[$i]=$p;
					$i++;	
				}
				print json_encode($this->resultArray);
					
			}else{
				print "0";
			}

		}
	}
}

?>