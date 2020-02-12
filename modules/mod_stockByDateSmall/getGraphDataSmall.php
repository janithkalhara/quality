<?php
require_once '../../includes/HDatabase.php';
require_once '../../libraries/base/project/lib_project.php';

if(isset($_POST['season'])){
	new RenderData($_POST);
}

if(isset($_POST['project'])){
	$project = $_POST['project'];
	$season = $_POST['seasonId'];

	if($project != ""){
		$con = new HDatabase();
		$con->connect();
	
		$con->select('qa_area qa,qa_gradeCategory qc','areaId,areaName',"areaName LIKE '$project%' AND qa.cate_id = qc.id AND qc.name ='Small' AND season='$season' ");
		$result = $con->getResult();

		if($result){
			foreach ($result as $r){
				$areaName = $r['areaName'];
				$areaId = $r['areaId'];

				echo '<li class="suglist" onclick="showAlert(this.id,\''.$areaName.'\')" id="'.$areaId.'">'.$r['areaName'].'</li>';

			}
		}else{
			echo "No projects";
		}		
	}
}

if(isset($_POST['getSeason'])){
	
	$db = new HDatabase();
	$db->connect();
	$db->select('qa_seasons',"seasonId","flag='1'");
	$seasonArr = $db->getResult();
	$seasonId = $seasonArr[0]['seasonId'];
	
	print $seasonId;
}

class RenderData{
	var $firstDate;
	var $endDate;
	var $season;
	var $project ;
	var $stationId;

	var $DQ;
	var $AQ;
	var $PQ;
	var $tDQ;
	var $RQ;

	var $vehicleNo;
	var $date;
	var $centers;
	var $tm;
	var $totDQ;
	var $rawValues;
	var $rawValues2;
	var $valueSet;
	var $valueSet2;

	function RenderData($arr){
		$this->firstDate = $arr['firstDate']." 00:00:00";
		$this->endDate = $arr['endDate']." 23:59:59";
		$this->season = $arr['season'];
		$this->project = $arr['projectData'];
		$this->stationId = $arr['stationId'];

		$this->DQ="";
		$this->AQ="";
		$this->PQ="";
		$this->RQ = "";

		settype($this->DQ,"double");
		settype($this->AQ,"double");
		settype($this->PQ,"double");
		settype($this->RQ,"double");

		$this->vehicleNo  = "";
		$this->date = "";
		$this->centers = "";
		$this->tm = "";
		$this->rawValues = "";
		$this->rawValues2 ="";
		$this->valueSet = "";
		$this->valueSet2 = "";

		if($this->stationId != "Total"){
			$this->getStationData();
		}else{
			$this->getTotalData();
		}
	}
	//getting data checking stations
	function getStationData() {
		$projectObj = new Project();
		
		if($this->project != ""){
			$projectId = $this->project;					
		}	
		
		if($this->project == ""){
			$db = new HDatabase();
			$db->connect();
			$db->select('qa_stockUpdates_small','*',"stationId='$this->stationId' AND date>='$this->firstDate' AND date<='$this->endDate'", "date ASC");
			$res = $db->getResult();			
		}else{
			$db = new HDatabase();
			$db->connect();
			$db->select('qa_stockUpdates_small','*',"stationId='$this->stationId' AND date>='$this->firstDate' AND date<='$this->endDate' AND areaId='$this->project'", "date ASC");
			$res = $db->getResult();
		}
		//print_r($res);

		if($res){
			foreach ($res as $resData){
				$this->vehicleNo = $resData['vehicleNo'];
				$this->date = $resData['date'];
				$projectId = $resData['areaId'];				
					
				$centDb = new HDatabase();
				$centDb->connect();
				$centDb->select('qa_small_crop','*',"date='$this->date' AND vehicleNo='$this->vehicleNo' AND id='$projectId'");
				$resCenter = $centDb->getResult();

				foreach ($resCenter as $r){
					$this->totDQ += $r['total_DQ'];
				}
				//print $this->totDQ;

				$tmdb = new HDatabase();
				$tmdb->connect();
				$tmdb->select('qa_centerQuantitySmall','center,tmNo',"date='$this->date' AND vehicleNo='$this->vehicleNo' AND id='$projectId'");
				$tmRes = $tmdb->getResult();

				foreach ($tmRes as $t){
					$this->centers .= $t['center']."<br/>";
					$this->tm .= $t['tmNo']."<br/>";
				}

				//print $this->centers."-";
				if($this->project == ""){
					$con = new HDatabase();
					$con->connect();
					$con->select('qa_small_belongs','*', "vehicleNo='$this->vehicleNo' AND date='$this->date' AND id='$projectId'", "date,gradeName ASC" );
					$result = $con->getResult();
				}else{
					$con = new HDatabase();
					$con->connect();
					$con->select('qa_small_belongs','*', "vehicleNo='$this->vehicleNo' AND date='$this->date' AND id='$this->project'", "date,gradeName ASC" );
					$result = $con->getResult();
				}			

				$totPQ1 = 0;
				$totPQ2 = 0;
				$totPQ3 = 0;
				$totPQ4 = 0;
				$totPQ5 = 0;

				settype($totPQ1,"double");
				settype($totPQ2,"double");
				settype($totPQ3,"double");
				settype($totPQ4,"double");
				settype($totPQ5,"double");

				$i=0;
				if($result){
					foreach($result as $resVal){
						$totPQ1 +=  $resVal['11-14'];
						$totPQ2 +=  $resVal['14-17'];
						$totPQ3 +=  $resVal['17-29'];
						$totPQ4 +=  $resVal['29-44'];
						$totPQ5 +=  $resVal['CRS'];
							
					}
					$totPQ = array();
					$totPQ[0] = $totPQ1;
					$totPQ[1] = $totPQ2;
					$totPQ[2] = $totPQ3;
					$totPQ[3] = $totPQ4;
					$totPQ[4] = $totPQ5;

					foreach($result as $resValues){
						$this->DQ = $resValues['DQ'];
						$this->AQ = $resValues['AQ'];
						//change
						$this->RQ = round(($resValues['AQ'] - $totPQ[$i]), 2);
						//$this->RQ = $resValues['reject'];

						if($i<3){
							$this->rawValues .= '
					<td rowspan="1">'.$this->DQ.'</td>
					<td rowspan="1">'.$this->AQ.'</td>
					<td rowspan="1">'.$this->RQ.'</td>
					<td rowspan="1">'.$totPQ[$i].'</td>
					
					';	
						}
						if($i >=3){
							$this->rawValues2 .= '
					<td rowspan="1">'.$this->DQ.'</td>
					<td rowspan="1">'.$this->AQ.'</td>
					<td rowspan="1">'.$this->RQ.'</td>
					<td rowspan="1">'.$totPQ[$i].'</td>
					';
						}
						$i++;
					}

					$this->valueSet .= '<tr style="text-align:center">
					<td rowspan="1">'.$this->date.'</td>
					<td rowspan="1">'.$this->centers.'</td>
					<td rowspan="1">'.$this->tm.'</td>
					<td rowspan="1">'.$this->totDQ.'</td>					
					'.$this->rawValues.'</tr>'	;	

					$this->valueSet2 .= '<tr style="text-align:center">
					<td rowspan="1">'.$this->date.'</td>
					<td rowspan="1">'.$this->centers.'</td>
					<td rowspan="1">'.$this->tm.'</td>
					<td rowspan="1">'.$this->totDQ.'</td>
					'.$this->rawValues2.'</tr>' ;

					$this->rawValues = "";
					$this->rawValues2 = "";

					$this->centers = "";
					$this->tm = "";
					$this->totDQ = "";

				}else{
					print "No Stocks";
					$this->centers = "";
					$this->tm = "";
					$this->totDQ = "";
				}
			}

			if($this->valueSet != "" && $this->valueSet2 != ""){
				print $this->valueSet.";".$this->valueSet2;
				$this->valueSet = "";
				$this->valueSet2 = "";
			}
		}else{
			print "0";
		}

	}

	function getTotalData() {
		$projectObj = new Project();
		
		if($this->project != ""){
			$projectIdNew = $this->project;					
		}	
		
		if($this->project == ""){
			$db = new HDatabase();
			$db->connect();
			$db->select('qa_stockUpdates_small','*',"date>='$this->firstDate' AND date<='$this->endDate'", "date ASC");
			$res = $db->getResult();			
		}else{
			$db = new HDatabase();
			$db->connect();
			$db->select('qa_stockUpdates_small','*',"date>='$this->firstDate' AND date<='$this->endDate' AND areaId='$projectIdNew'", "date ASC");
			$res = $db->getResult();
		}
		//print_r($res);

		if($res){
			foreach ($res as $resData){
				$this->vehicleNo = $resData['vehicleNo'];
				$this->date = $resData['date'];
				$projectId = $resData['areaId'];
					
				$centDb = new HDatabase();
				$centDb->connect();
				$centDb->select('qa_small_crop','*',"date='$this->date' AND vehicleNo='$this->vehicleNo' AND id='$projectId'");
				$resCenter = $centDb->getResult();

				foreach ($resCenter as $r){
					$this->totDQ += $r['total_DQ'];
				}
				//print $this->totDQ;

				$tmdb = new HDatabase();
				$tmdb->connect();
				$tmdb->select('qa_centerQuantitySmall','center,tmNo',"date='$this->date' AND vehicleNo='$this->vehicleNo' AND id='$projectId'");
				$tmRes = $tmdb->getResult();

				foreach ($tmRes as $t){
					$this->centers .= $t['center']."<br/>";
					$this->tm .= $t['tmNo']."<br/>";
				}

				//print $this->centers."-";
				if($this->project == ""){
					$con = new HDatabase();
					$con->connect();
					$con->select('qa_small_belongs','*', "vehicleNo='$this->vehicleNo' AND date='$this->date' AND id='$projectId'", "date,gradeName ASC" );
					$result = $con->getResult();
				}else{
					$con = new HDatabase();
					$con->connect();
					$con->select('qa_small_belongs','*', "vehicleNo='$this->vehicleNo' AND date='$this->date' AND id='$this->project'", "date,gradeName ASC" );
					$result = $con->getResult();
				}			

				$totPQ1 = 0;
				$totPQ2 = 0;
				$totPQ3 = 0;
				$totPQ4 = 0;
				$totPQ5 = 0;

				settype($totPQ1,"double");
				settype($totPQ2,"double");
				settype($totPQ3,"double");
				settype($totPQ4,"double");
				settype($totPQ5,"double");

				$i=0;
				if($result){
					foreach($result as $resVal){
						$totPQ1 +=  $resVal['11-14'];
						$totPQ2 +=  $resVal['14-17'];
						$totPQ3 +=  $resVal['17-29'];
						$totPQ4 +=  $resVal['29-44'];
						$totPQ5 +=  $resVal['CRS'];
							
					}
					$totPQ = array();
					$totPQ[0] = $totPQ1;
					$totPQ[1] = $totPQ2;
					$totPQ[2] = $totPQ3;
					$totPQ[3] = $totPQ4;
					$totPQ[4] = $totPQ5;

					foreach($result as $resValues){
						$this->DQ = $resValues['DQ'];
						$this->AQ = $resValues['AQ'];
						$this->RQ = $resValues['reject'];

						if($i<3){
							$this->rawValues .= '
					<td rowspan="1">'.$this->DQ.'</td>
					<td rowspan="1">'.$this->AQ.'</td>
					<td rowspan="1">'.$this->RQ.'</td>
					<td rowspan="1">'.$totPQ[$i].'</td>
					
					';	
						}if($i >=3){
							$this->rawValues2 .= '
					<td rowspan="1">'.$this->DQ.'</td>
					<td rowspan="1">'.$this->AQ.'</td>
					<td rowspan="1">'.$this->RQ.'</td>
					<td rowspan="1">'.$totPQ[$i].'</td>
					';
						}
						$i++;
					}

					$this->valueSet .= '<tr style="text-align:center">
					<td rowspan="1">'.$this->date.'</td>
					<td rowspan="1">'.$this->centers.'</td>
					<td rowspan="1">'.$this->tm.'</td>
					<td rowspan="1">'.$this->totDQ.'</td>					
					'.$this->rawValues.'</tr>'	;	

					$this->valueSet2 .= '<tr style="text-align:center">
					<td rowspan="1">'.$this->date.'</td>
					<td rowspan="1">'.$this->centers.'</td>
					<td rowspan="1">'.$this->tm.'</td>
					<td rowspan="1">'.$this->totDQ.'</td>
					'.$this->rawValues2.'</tr>' ;

					$this->rawValues = "";
					$this->rawValues2 = "";

					$this->centers = "";
					$this->tm = "";
					$this->totDQ = "";

				}else{
					print "No Stocks";
					$this->centers = "";
					$this->tm = "";
					$this->totDQ = "";
				}
			}

			if($this->valueSet != "" && $this->valueSet2 != ""){
				print $this->valueSet.";".$this->valueSet2;
				$this->valueSet = "";
				$this->valueSet2 = "";
			}
		}else{
			print "0";
		}

	}


}


?>