
<?php
require_once '../../includes/HDatabase.php';
require_once '../../libraries/base/project/lib_project.php';


if(isset($_POST['firstDate'])){
	new RenderData($_POST);
}

if(isset($_POST['projectName'])){
	$project = $_POST['projectName'];
	$seasonId = $_POST['seasonId'];

	$con = new HDatabase();
	$con->connect();


	if($project != ""){
		$con->resetResult();
		$con->select('qa_area a, qa_gradeCategory g','areaId,areaName,cate_id',"areaName LIKE '$project%' AND a.cate_id = g.id AND g.name !=  'Small' AND season='$seasonId' ");
		$result = $con->getResult();

		if($result){
			$html = '';
			foreach ($result as $r){
				$areaName = $r['areaName'];
				$areaId = $r['areaId'];
				$gradeCategoryId = $r['cate_id'];
				$html .= '<li class="suglist list-trigger" data-id="'.$areaId.'" data-cate="'.$gradeCategoryId.'" data-aname="'.$areaName.'"> '.$areaName.'</li>';
				//echo '<li class="suglist" onclick=showAlert(this.id,"'.$gradeCategoryId.'","'.$areaName.'") id="'.$areaId.'">'.$r['areaName'].'</li>';

			}
			echo $html;
		}else{
			echo "No projects";

		}
	}
}

if(isset($_POST['gradeCat'])){
	$gradeCat = $_POST['gradeCat'];

	$getGrade = new HDatabase();
	$getGrade->connect();
	$getGrade->select('qa_grade g,qa_gradeCategory gc','fruitCount',"g.cate_id = gc.id AND gc.id='$gradeCat'","gradeId ASC");
	$res = $getGrade->getResult();

	$i = 0;
	$grades = array();
	foreach ($res as $rr){
		$grades[$i] = $rr['fruitCount'];
		$i++;
	}
	print json_encode($grades);
}

//setting the activated season
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
	var $grade;
	var $gradeArr;

	var $DQ;
	var $AQ;
	var $PQ;
	var $tDQ;
	var $RQ;

	var $vehicleNo;
	var $date;
	var $centers;
	var $tm;
	var $rawValues;
	var $rawValues2;

	var $valueSet;
	var $tableRaw;
	var $tableRaw2;

	var $k;
	var $oldGrade;

	function RenderData($arr){
		$this->firstDate = $arr['firstDate']." 00:00:00";
		$this->endDate = $arr['endDate']." 23:59:59";
		$this->season = $arr['season'];
		$this->project = $arr['project'];
		$this->stationId = $arr['stationId'];
		$this->grade = $arr['grade'];

		$projectObj = new Project();

		$con = new HDatabase();
		$con->connect();
		$con->select('qa_grade','gradeId',"cate_id='$this->grade'","gradeId ASC");
		$rr = $con->getResult();

		for($i=0;$i<count($rr);$i++){
			$this->gradeArr[$i] = $rr[$i]['gradeId'];
		}

		$this->DQ="";
		$this->AQ="";
		$this->PQ="";
		$this->tDQ = "";
		$this->RQ = "";

		settype($this->DQ,"double");
		settype($this->AQ,"double");
		settype($this->PQ,"double");
		settype($this->tDQ,"double");
		settype($this->RQ,"double");

		$this->vehicleNo  = "";
		$this->date = "";
		$this->centers = "";
		$this->tm = "";
		$this->rawValues = "";
		$this->rawValues2 ="";

		$this->valueSet = "";
		$this->tableRaw = "";
		$this->tableRaw2 = "";

		if($this->firstDate <= $this->endDate){

			if($this->project == ""){
				if($this->stationId != "Total"){
					$db = new HDatabase();
					$db->connect();
					$db->select('qa_stockUpdates','*',"stationId='$this->stationId' AND date>='$this->firstDate' AND date<='$this->endDate'", "date ASC");
					$res = $db->getResult();

					if($res){
						foreach ($res as $rVehicle){
							$this->vehicleNo = $rVehicle['vehicleNo'];
							$this->date = $rVehicle['date'];

							$projectId = $rVehicle['areaId'];

							$con = new HDatabase();
							$con->connect();
							$con->select('qa_gradeStock','*', "vehicleNo='$this->vehicleNo' AND date='$this->date' AND id='$projectId'", "date,gradeId ASC" );
							$result = $con->getResult();

							$crsNo = 0;

							if($result){
								foreach ($result as $r){
									$newVehicleNo = $r['vehicleNo'];
									$newDate = $r['date'];
									$this->project = $r['id'];
									$gradeId = $r['gradeId'];


									if(in_array($gradeId, $this->gradeArr)){
										$this->k =1;
										if($newVehicleNo == $this->vehicleNo && $newDate == $this->date){
											$this->DQ = $r['notedWeight'];
											$this->AQ = $r['trueWeight'];
											$this->PQ = $r['payableQuantity'];

											$conn = new HDatabase();
											$conn->connect();
											$conn->select('qa_grade','fruitCount',"gradeId = '$gradeId'");
											$ress = $conn->getResult();
											$gradeCat = $ress[0]['fruitCount'];

											$crsNo++;
											if(count($rr) == 4){
												if($crsNo ==1 && $gradeId == $this->gradeArr[$crsNo]){
													$this->valueSet .= "".":"."".":".""."-";
												}
												if($crsNo ==1 && $gradeId == $this->gradeArr[$crsNo+1]){
													$this->valueSet .= "".":"."".":".""."-";
													$this->valueSet .= "".":"."".":".""."-";
												}
												if($crsNo ==1 && $gradeId == $this->gradeArr[$crsNo+2]){
													$this->valueSet .= "".":"."".":".""."-";
													$this->valueSet .= "".":"."".":".""."-";
													$this->valueSet .= "".":"."".":".""."-";
												}
												if($crsNo ==2 && $gradeId == $this->gradeArr[$crsNo] && $this->oldGrade == $this->gradeArr[$crsNo-2]){
													$this->valueSet .= "".":"."".":".""."-";
												}

												if($crsNo ==2 && $gradeId == $this->gradeArr[$crsNo+1] && $this->oldGrade != $this->gradeArr[$crsNo] && $this->oldGrade != $this->gradeArr[$crsNo-1]){
													$this->valueSet .= "".":"."".":".""."-";
													$this->valueSet .= "".":"."".":".""."-";
												}

												if($crsNo ==2 && $gradeId == $this->gradeArr[$crsNo+1] && $this->oldGrade == $this->gradeArr[$crsNo-1]){
													$this->valueSet .= "".":"."".":".""."-";
														
												}

												if($crsNo ==3 && $gradeId == $this->gradeArr[$crsNo] && $this->oldGrade != $this->gradeArr[2]){
													$this->valueSet .= "".":"."".":".""."-";
												}

											}else{
												if($crsNo ==1 && $gradeId == $this->gradeArr[$crsNo]){
													$this->valueSet .= "".":"."".":".""."-";
												}
												if($crsNo ==1 && $gradeId == $this->gradeArr[$crsNo+1]){
													$this->valueSet .= "".":"."".":".""."-";
													$this->valueSet .= "".":"."".":".""."-";
												}

												if($crsNo ==1 && $gradeId == $this->gradeArr[$crsNo+1] && $this->oldGrade == $this->gradeArr[$crsNo-1]){
													$this->valueSet .= "".":"."".":".""."-";
												}


												if($crsNo ==2 && $gradeId == $this->gradeArr[$crsNo] && $this->oldGrade != $this->gradeArr[$crsNo-1] ){
													$this->valueSet .= "".":"."".":".""."-";
												}

											}
											$this->oldGrade=$gradeId;
											$this->valueSet .= $this->DQ.":".$this->AQ.":".$this->PQ."-";
											//print $this->valueSet;


										}else{
											if($this->valueSet != ""){
												$getCenter = new HDatabase();
												$getCenter->connect();
												$getCenter->select('qa_centerQuantity','center,tmNo',"id='$this->project' AND date='$this->date' AND vehicleNo='$this->vehicleNo'");
												$resCenter = $getCenter->getResult();

												foreach ($resCenter as $rc){
													$this->centers .= $rc['center'].'<br/>';
													$this->tm .= $rc['tmNo'].'<br/>';
												}

												$valueSetNew = split("-", $this->valueSet);
												//print_r($valueSetNew);

												for($i=0;$i<4;$i++){
													$values = split(":", $valueSetNew[$i]);
													if($values[0] != "" && $values[1] != ""){
														$this->RQ = $values[1]-$values[2];
														$this->RQ = round($this->RQ,2);
													}else{
														$this->RQ = "";
													}
													if($i<2){
														$this->rawValues .= '<td>'.$values[0].'</td><td>'.$values[1].'</td><td>'.$this->RQ.'</td><td>'.$values[2].'</td>';
														$this->tDQ += $values[0];
													}
													else{
														$this->rawValues2 .= '<td>'.$values[0].'</td><td>'.$values[1].'</td><td>'.$this->RQ.'</td><td>'.$values[2].'</td>';
														$this->tDQ += $values[0];
													}
												}


												$this->tableRaw .= '<tr>
					<td rowspan="1">'.$this->date.'</td>
					<td rowspan="1">'.$this->centers.'</td>
					<td rowspan="1">'.$this->tm.'</td>
					<td rowspan="1">'.$this->tDQ.'</td>
					
					'.$this->rawValues.'</tr>'	;	

												$this->tableRaw2 .= '<tr>
					<td rowspan="1">'.$this->date.'</td>
					<td rowspan="1">'.$this->centers.'</td>
					<td rowspan="1">'.$this->tm.'</td>
					<td rowspan="1">'.$this->tDQ.'</td>
					'.$this->rawValues2.'</tr>'	;

												$this->rawValues = "";
												$this->rawValues2 ="";
												$this->centers = "";
												$this->tm = "";
												$this->tDQ = "";
											}

											$this->vehicleNo = $newVehicleNo;
											$this->date = $newDate;

											$this->DQ = $r['notedWeight'];
											$this->AQ = $r['trueWeight'];
											$this->PQ = $r['payableQuantity'];

											$this->valueSet = $this->DQ.":".$this->AQ.":".$this->PQ."-";
											$crsNo = 0;

										}

									}else{
										$this->k = 0;
									}
								}
								if($this->k==1){
									$this->printRaw();
								}
							}

						}
					}//end of checking result
				}//end of checking total

				else{
					$db = new HDatabase();
					$db->connect();
					$db->select('qa_stockUpdates','*',"date>='$this->firstDate' AND date<='$this->endDate'", "date ASC");
					$res = $db->getResult();
					//print_r($res);
					if($res){
						foreach ($res as $rVehicle){
							$this->vehicleNo = $rVehicle['vehicleNo'];
							$this->date = $rVehicle['date'];
							$projectId = $rVehicle['areaId'];

							$con = new HDatabase();
							$con->connect();
							$con->select('qa_gradeStock','*', "vehicleNo='$this->vehicleNo' AND date='$this->date' AND id='$projectId'", "date,gradeId ASC" );
							$result = $con->getResult();

							$crsNo = 0;

							if($result){
								foreach ($result as $r){
									$newVehicleNo = $r['vehicleNo'];
									$newDate = $r['date'];
									$this->project = $r['id'];
									$gradeId = $r['gradeId'];

									if(in_array($gradeId, $this->gradeArr)){
										$this->k =1;
										if($newVehicleNo == $this->vehicleNo && $newDate == $this->date){
											$this->DQ = $r['notedWeight'];
											$this->AQ = $r['trueWeight'];
											$this->PQ = $r['payableQuantity'];

											$conn = new HDatabase();
											$conn->connect();
											$conn->select('qa_grade','fruitCount',"gradeId = '$gradeId'");
											$ress = $conn->getResult();
											$gradeCat = $ress[0]['fruitCount'];

											$crsNo++;
											if(count($rr) == 4){
												if($crsNo ==1 && $gradeId == $this->gradeArr[$crsNo]){
													$this->valueSet .= "".":"."".":".""."-";
												}
												if($crsNo ==1 && $gradeId == $this->gradeArr[$crsNo+1]){
													$this->valueSet .= "".":"."".":".""."-";
													$this->valueSet .= "".":"."".":".""."-";
												}
												if($crsNo ==1 && $gradeId == $this->gradeArr[$crsNo+2]){
													$this->valueSet .= "".":"."".":".""."-";
													$this->valueSet .= "".":"."".":".""."-";
													$this->valueSet .= "".":"."".":".""."-";
												}
												if($crsNo ==2 && $gradeId == $this->gradeArr[$crsNo] && $this->oldGrade == $this->gradeArr[$crsNo-2]){
													$this->valueSet .= "".":"."".":".""."-";
												}

												if($crsNo ==2 && $gradeId == $this->gradeArr[$crsNo+1] && $this->oldGrade != $this->gradeArr[$crsNo] && $this->oldGrade != $this->gradeArr[$crsNo-1]){
													$this->valueSet .= "".":"."".":".""."-";
													$this->valueSet .= "".":"."".":".""."-";
												}

												if($crsNo ==2 && $gradeId == $this->gradeArr[$crsNo+1] && $this->oldGrade == $this->gradeArr[$crsNo-1]){
													$this->valueSet .= "".":"."".":".""."-";
														
												}

												if($crsNo ==3 && $gradeId == $this->gradeArr[$crsNo] && $this->oldGrade != $this->gradeArr[2]){
													$this->valueSet .= "".":"."".":".""."-";
												}

											}else{
												if($crsNo ==1 && $gradeId == $this->gradeArr[$crsNo]){
													$this->valueSet .= "".":"."".":".""."-";
												}
												if($crsNo ==1 && $gradeId == $this->gradeArr[$crsNo+1]){
													$this->valueSet .= "".":"."".":".""."-";
													$this->valueSet .= "".":"."".":".""."-";
												}

												if($crsNo ==1 && $gradeId == $this->gradeArr[$crsNo+1] && $this->oldGrade == $this->gradeArr[$crsNo-1]){
													$this->valueSet .= "".":"."".":".""."-";
												}


												if($crsNo ==2 && $gradeId == $this->gradeArr[$crsNo] && $this->oldGrade != $this->gradeArr[$crsNo-1]){
													$this->valueSet .= "".":"."".":".""."-";
												}

											}
											$this->oldGrade=$gradeId;

											$this->valueSet .= $this->DQ.":".$this->AQ.":".$this->PQ."-";
											//print $this->valueSet;

										}else{
											if($this->valueSet != ""){
												$getCenter = new HDatabase();
												$getCenter->connect();
												$getCenter->select('qa_centerQuantity','center,tmNo',"id='$this->project' AND date='$this->date' AND vehicleNo='$this->vehicleNo'");
												$resCenter = $getCenter->getResult();

												foreach ($resCenter as $rc){
													$this->centers .= $rc['center'].'<br/>';
													$this->tm .= $rc['tmNo'].'<br/>';
												}

												$valueSetNew = split("-", $this->valueSet);
												//print_r($valueSetNew);

												for($i=0;$i<4;$i++){
													$values = split(":", $valueSetNew[$i]);
													if($values[0] != "" && $values[1] != ""){
														$this->RQ = $values[1]-$values[2];
														$this->RQ = round($this->RQ,2);
													}else{
														$this->RQ = "";
													}
													if($i<2){
														$this->rawValues .= '<td>'.$values[0].'</td><td>'.$values[1].'</td><td>'.$this->RQ.'</td><td>'.$values[2].'</td>';
														$this->tDQ += $values[0];
													}
													else{
														$this->rawValues2 .= '<td>'.$values[0].'</td><td>'.$values[1].'</td><td>'.$this->RQ.'</td><td>'.$values[2].'</td>';
														$this->tDQ += $values[0];
													}
												}


												$this->tableRaw .= '<tr>
					<td rowspan="1">'.$this->date.'</td>
					<td rowspan="1">'.$this->centers.'</td>
					<td rowspan="1">'.$this->tm.'</td>
					<td rowspan="1">'.$this->tDQ.'</td>
					
					'.$this->rawValues.'</tr>'	;	

												$this->tableRaw2 .= '<tr>
					<td rowspan="1">'.$this->date.'</td>
					<td rowspan="1">'.$this->centers.'</td>
					<td rowspan="1">'.$this->tm.'</td>
					<td rowspan="1">'.$this->tDQ.'</td>
					'.$this->rawValues2.'</tr>'	;

												$this->rawValues = "";
												$this->rawValues2 ="";
												$this->centers = "";
												$this->tm = "";
												$this->tDQ = "";
											}

											$this->vehicleNo = $newVehicleNo;
											$this->date = $newDate;

											$this->DQ = $r['notedWeight'];
											$this->AQ = $r['trueWeight'];
											$this->PQ = $r['payableQuantity'];

											$this->valueSet = $this->DQ.":".$this->AQ.":".$this->PQ."-";
											$crsNo = 0;
										}

									}else{
										$this->k = 0;
									}
								}
								if($this->k==1){
									$this->printRaw();
								}
							}

						}

					}//end of checking result
				}
			}// end of if($project=="")


			else{

				$projectId = $this->project;
					
					
				if($this->stationId == "Total"){
					$db = new HDatabase();
					$db->connect();
					$db->select('qa_stockUpdates','*',"date>='$this->firstDate' AND date<='$this->endDate' AND areaId='$projectId'", "date ASC");
					$res = $db->getResult();

					foreach ($res as $rVehicle){
						$this->vehicleNo = $rVehicle['vehicleNo'];
						$this->date = $rVehicle['date'];

						$con = new HDatabase();
						$con->connect();
						$con->select('qa_gradeStock','*', "vehicleNo='$this->vehicleNo' AND date='$this->date' AND id='$this->project'", "date,gradeId ASC" );
						$result = $con->getResult();

						$crsNo = 0;
						if($result){
							foreach ($result as $r){
								$newVehicleNo = $r['vehicleNo'];
								$newDate = $r['date'];

								$this->project = $r['id'];
								$gradeId = $r['gradeId'];
									
								if($this->project == $r['id']){
									$this->k =1;
									if($newVehicleNo == $this->vehicleNo && $newDate == $this->date){
										$this->DQ = $r['notedWeight'];
										$this->AQ = $r['trueWeight'];
										$this->PQ = $r['payableQuantity'];

										$conn = new HDatabase();
										$conn->connect();
										$conn->select('qa_grade','fruitCount',"gradeId = '$gradeId'");
										$ress = $conn->getResult();
										$gradeCat = $ress[0]['fruitCount'];

										$crsNo++;
										if(count($rr) == 4){
											if($crsNo ==1 && $gradeId == $this->gradeArr[$crsNo]){
												$this->valueSet .= "".":"."".":".""."-";
											}
											if($crsNo ==1 && $gradeId == $this->gradeArr[$crsNo+1]){
												$this->valueSet .= "".":"."".":".""."-";
												$this->valueSet .= "".":"."".":".""."-";
											}
											if($crsNo ==1 && $gradeId == $this->gradeArr[$crsNo+2]){
												$this->valueSet .= "".":"."".":".""."-";
												$this->valueSet .= "".":"."".":".""."-";
												$this->valueSet .= "".":"."".":".""."-";
											}
											if($crsNo ==2 && $gradeId == $this->gradeArr[$crsNo] && $this->oldGrade == $this->gradeArr[$crsNo-2]){
												$this->valueSet .= "".":"."".":".""."-";
											}

											if($crsNo ==2 && $gradeId == $this->gradeArr[$crsNo+1] && $this->oldGrade != $this->gradeArr[$crsNo] && $this->oldGrade != $this->gradeArr[$crsNo-1]){
												$this->valueSet .= "".":"."".":".""."-";
												$this->valueSet .= "".":"."".":".""."-";
											}

											if($crsNo ==2 && $gradeId == $this->gradeArr[$crsNo+1] && $this->oldGrade == $this->gradeArr[$crsNo-1]){
												$this->valueSet .= "".":"."".":".""."-";
													
											}

											if($crsNo ==3 && $gradeId == $this->gradeArr[$crsNo] && $this->oldGrade != $this->gradeArr[2]){
												$this->valueSet .= "".":"."".":".""."-";
											}

										}else{
											if($crsNo ==1 && $gradeId == $this->gradeArr[$crsNo]){
												$this->valueSet .= "".":"."".":".""."-";
											}
											if($crsNo ==1 && $gradeId == $this->gradeArr[$crsNo+1]){
												$this->valueSet .= "".":"."".":".""."-";
												$this->valueSet .= "".":"."".":".""."-";
											}

											if($crsNo ==1 && $gradeId == $this->gradeArr[$crsNo+1] && $this->oldGrade == $this->gradeArr[$crsNo-1]){
												$this->valueSet .= "".":"."".":".""."-";
											}


											if($crsNo ==2 && $gradeId == $this->gradeArr[$crsNo] && $this->oldGrade != $this->gradeArr[$crsNo-1]){
												$this->valueSet .= "".":"."".":".""."-";
											}

										}
										$this->oldGrade=$gradeId;


										$this->valueSet .= $this->DQ.":".$this->AQ.":".$this->PQ."-";
										//print $this->valueSet;

									}else{
										if($this->valueSet != ""){
											$getCenter = new HDatabase();
											$getCenter->connect();
											$getCenter->select('qa_centerQuantity','center,tmNo',"id='$this->project' AND date='$this->date' AND vehicleNo='$this->vehicleNo'");
											$resCenter = $getCenter->getResult();

											foreach ($resCenter as $rc){
												$this->centers .= $rc['center'].'<br/>';
												$this->tm .= $rc['tmNo'].'<br/>';
											}

											$valueSetNew = split("-", $this->valueSet);
											//print_r($valueSetNew);

											for($i=0;$i<4;$i++){
												$values = split(":", $valueSetNew[$i]);
												if($values[0] != "" && $values[1] != ""){
													$this->RQ = $values[1]-$values[2];
													$this->RQ = round($this->RQ,2);
												}else{
													$this->RQ = "";
												}
												if($i<2){
													$this->rawValues .= '<td>'.$values[0].'</td><td>'.$values[1].'</td><td>'.$this->RQ.'</td><td>'.$values[2].'</td>';
													$this->tDQ += $values[0];
												}
												else{
													$this->rawValues2 .= '<td>'.$values[0].'</td><td>'.$values[1].'</td><td>'.$this->RQ.'</td><td>'.$values[2].'</td>';
													$this->tDQ += $values[0];
												}
											}


											$this->tableRaw .= '<tr>
					<td rowspan="1">'.$this->date.'</td>
					<td rowspan="1">'.$this->centers.'</td>
					<td rowspan="1">'.$this->tm.'</td>
					<td rowspan="1">'.$this->tDQ.'</td>
					
					'.$this->rawValues.'</tr>'	;	

											$this->tableRaw2 .= '<tr>
					<td rowspan="1">'.$this->date.'</td>
					<td rowspan="1">'.$this->centers.'</td>
					<td rowspan="1">'.$this->tm.'</td>
					<td rowspan="1">'.$this->tDQ.'</td>
					'.$this->rawValues2.'</tr>'	;

											$this->rawValues = "";
											$this->rawValues2 ="";
											$this->centers = "";
											$this->tm = "";
											$this->tDQ = "";
										}

										$this->vehicleNo = $newVehicleNo;
										$this->date = $newDate;

										$this->DQ = $r['notedWeight'];
										$this->AQ = $r['trueWeight'];
										$this->PQ = $r['payableQuantity'];

										$this->valueSet = $this->DQ.":".$this->AQ.":".$this->PQ."-";
										$crsNo = 0;
									}

								}else{
									$this->k = 0;
								}
							}
							if($this->k==1){
								$this->printRaw();
							}
						}

					}
				} //end of if(total)

				else{
					$db = new HDatabase();
					$db->connect();
					$db->select('qa_stockUpdates','*',"stationId='$this->stationId' AND date>='$this->firstDate' AND date<='$this->endDate' AND areaId='$projectId'", "date ASC");
					$res = $db->getResult();
					//print_r($res);
					if($res){
						foreach ($res as $rVehicle){
							$this->vehicleNo = $rVehicle['vehicleNo'];
							$this->date = $rVehicle['date'];

							$con = new HDatabase();
							$con->connect();
							$con->select('qa_gradeStock','*', "vehicleNo='$this->vehicleNo' AND date='$this->date' AND id='$this->project'", "date,gradeId ASC" );
							$result = $con->getResult();

							$crsNo = 0;
							if($result){
								foreach ($result as $r){
									$newVehicleNo = $r['vehicleNo'];
									$newDate = $r['date'];

									$this->project = $r['id'];
									$gradeId = $r['gradeId'];

									if($this->project == $r['id']){
										$this->k =1;
										if($newVehicleNo == $this->vehicleNo && $newDate == $this->date){
											$this->DQ = $r['notedWeight'];
											$this->AQ = $r['trueWeight'];
											$this->PQ = $r['payableQuantity'];

											$conn = new HDatabase();
											$conn->connect();
											$conn->select('qa_grade','fruitCount',"gradeId = '$gradeId'");
											$ress = $conn->getResult();
											$gradeCat = $ress[0]['fruitCount'];

											$crsNo++;
											if(count($rr) == 4){
												if($crsNo ==1 && $gradeId == $this->gradeArr[$crsNo]){
													$this->valueSet .= "".":"."".":".""."-";
												}
												if($crsNo ==1 && $gradeId == $this->gradeArr[$crsNo+1]){
													$this->valueSet .= "".":"."".":".""."-";
													$this->valueSet .= "".":"."".":".""."-";
												}
												if($crsNo ==1 && $gradeId == $this->gradeArr[$crsNo+2]){
													$this->valueSet .= "".":"."".":".""."-";
													$this->valueSet .= "".":"."".":".""."-";
													$this->valueSet .= "".":"."".":".""."-";
												}
												if($crsNo ==2 && $gradeId == $this->gradeArr[$crsNo] && $this->oldGrade == $this->gradeArr[$crsNo-2]){
													$this->valueSet .= "".":"."".":".""."-";
												}

												if($crsNo ==2 && $gradeId == $this->gradeArr[$crsNo+1] && $this->oldGrade != $this->gradeArr[$crsNo] && $this->oldGrade != $this->gradeArr[$crsNo-1]){
													$this->valueSet .= "".":"."".":".""."-";
													$this->valueSet .= "".":"."".":".""."-";
												}

												if($crsNo ==2 && $gradeId == $this->gradeArr[$crsNo+1] && $this->oldGrade == $this->gradeArr[$crsNo-1]){
													$this->valueSet .= "".":"."".":".""."-";
														
												}

												if($crsNo ==3 && $gradeId == $this->gradeArr[$crsNo] && $this->oldGrade != $this->gradeArr[2]){
													$this->valueSet .= "".":"."".":".""."-";
												}

											}else{
												if($crsNo ==1 && $gradeId == $this->gradeArr[$crsNo]){
													$this->valueSet .= "".":"."".":".""."-";
												}
												if($crsNo ==1 && $gradeId == $this->gradeArr[$crsNo+1]){
													$this->valueSet .= "".":"."".":".""."-";
													$this->valueSet .= "".":"."".":".""."-";
												}

												if($crsNo ==1 && $gradeId == $this->gradeArr[$crsNo+1] && $this->oldGrade == $this->gradeArr[$crsNo-1]){
													$this->valueSet .= "".":"."".":".""."-";
												}


												if($crsNo ==2 && $gradeId == $this->gradeArr[$crsNo] && $this->oldGrade != $this->gradeArr[$crsNo-1]){
													$this->valueSet .= "".":"."".":".""."-";
												}

											}
											$this->oldGrade=$gradeId;
											$this->valueSet .= $this->DQ.":".$this->AQ.":".$this->PQ."-";
											//print $this->valueSet;

										}else{
											if($this->valueSet != ""){
												$getCenter = new HDatabase();
												$getCenter->connect();
												$getCenter->select('qa_centerQuantity','center,tmNo',"id='$this->project' AND date='$this->date' AND vehicleNo='$this->vehicleNo'");
												$resCenter = $getCenter->getResult();

												foreach ($resCenter as $rc){
													$this->centers .= $rc['center'].'<br/>';
													$this->tm .= $rc['tmNo'].'<br/>';
												}

												$valueSetNew = split("-", $this->valueSet);
												//print_r($valueSetNew);

												for($i=0;$i<4;$i++){
													$values = split(":", $valueSetNew[$i]);
													if($values[0] != "" && $values[1] != ""){
														$this->RQ = $values[1]-$values[2];
														$this->RQ = round($this->RQ,2);
													}else{
														$this->RQ = "";
													}
													if($i<2){
														$this->rawValues .= '<td width="400px">'.$values[0].'</td><td width="400px">'.$values[1].'</td><td width="400px">'.$this->RQ.'</td><td width="400px">'.$values[2].'</td>';
														$this->tDQ += $values[0];
													}
													else{
														$this->rawValues2 .= '<td width="400px">'.$values[0].'</td><td width="400px">'.$values[1].'</td><td width="400px">'.$this->RQ.'</td><td width="400px">'.$values[2].'</td>';
														$this->tDQ += $values[0];
													}
												}


												$this->tableRaw .= '<tr style="text-align: center">
					<td rowspan="1">'.$this->date.'</td>
					<td rowspan="1">'.$this->centers.'</td>
					<td rowspan="1">'.$this->tm.'</td>
					<td rowspan="1">'.$this->tDQ.'</td>
					
					'.$this->rawValues.'</tr>'	;	

												$this->tableRaw2 .= '<tr style="text-align: center">
					<td rowspan="1">'.$this->date.'</td>
					<td rowspan="1">'.$this->centers.'</td>
					<td rowspan="1">'.$this->tm.'</td>
					<td rowspan="1">'.$this->tDQ.'</td>
					'.$this->rawValues2.'</tr>'	;

												$this->rawValues = "";
												$this->rawValues2 ="";
												$this->centers = "";
												$this->tm = "";
												$this->tDQ = "";
											}

											$this->vehicleNo = $newVehicleNo;
											$this->date = $newDate;

											$this->DQ = $r['notedWeight'];
											$this->AQ = $r['trueWeight'];
											$this->PQ = $r['payableQuantity'];

											$this->valueSet = $this->DQ.":".$this->AQ.":".$this->PQ."-";
											$crsNo = 0;
										}

									}else{
										$this->k = 0;
									}
								}
								if($this->k==1){
									$this->printRaw();
								}
							}
						}
					}else{
						print "No Stocks";
					}
				}
			}//end of else
		}
	}

	function printRaw(){

		$getCenter = new HDatabase();
		$getCenter->connect();
		$getCenter->select('qa_centerQuantity','center,tmNo',"id='$this->project' AND date='$this->date' AND vehicleNo='$this->vehicleNo'");
		$resCenter = $getCenter->getResult();

		foreach ($resCenter as $rc){
			$this->centers .= $rc['center'].'<br/>';
			$this->tm .= $rc['tmNo'].'<br/>';
		}

		$valueSetNew = split("-", $this->valueSet);
		//print_r($valueSet);

		for($i=0;$i<4;$i++){
			$values = split(":", $valueSetNew[$i]);
			if($values[0] != "" && $values[1] != ""){
				$this->RQ = $values[1]-$values[2];
				$this->RQ = round($this->RQ,2);
			}else{
				$this->RQ = "";
			}
			if($i<2){
				$this->rawValues .= '<td width="400px">'.$values[0].'</td><td width="400px">'.$values[1].'</td><td width="400px">'.$this->RQ.'</td><td width="400px">'.$values[2].'</td>';
				$this->tDQ += $values[0];
			}
			else{
				$this->rawValues2 .= '<td width="400px">'.$values[0].'</td><td width="400px">'.$values[1].'</td><td width="400px">'.$this->RQ.'</td><td width="400px">'.$values[2].'</td>';
				$this->tDQ += $values[0];
			}
		}

		$this->tableRaw .= '<tr style="text-align: center">
					<td rowspan="1">'.$this->date.'</td>
					<td rowspan="1">'.$this->centers.'</td>
					<td rowspan="1">'.$this->tm.'</td>
					<td rowspan="1">'.$this->tDQ.'</td>
					
					'.$this->rawValues.'</tr>'	;	

		$this->tableRaw2 .= '<tr style="text-align: center">
					<td rowspan="1">'.$this->date.'</td>
					<td rowspan="1">'.$this->centers.'</td>
					<td rowspan="1">'.$this->tm.'</td>
					<td rowspan="1">'.$this->tDQ.'</td>
					'.$this->rawValues2.'</tr>'	;	

		echo $this->tableRaw.";";
		echo $this->tableRaw2."*";

		$this->tableRaw = "";
		$this->tableRaw2 = "";
		$this->valueSet = "";
		$this->rawValues = "";
		$this->rawValues2 ="";
		$this->centers = "";
		$this->tm = "";
		$this->tDQ = "";
	}

}

?>

