
<?php
session_start();
if(!isset($_SESSION['SESS_MEMBER_ID']))die();


require_once '../../includes/HDatabase.php';
require_once '../../libraries/base/season/lib_season.php';

if(isset($_POST['userId'])){
	$userId = $_POST['userId'];
	$userData = array();

	$conn = new HDatabase();
	$conn->connect();
	$conn->select('qa_user','*',"userId='$userId'");
	$res = $conn->getResult();

	if($res){
		foreach ($res as $r){
			$userData[0] =  $r['avatar'];
			$userData[1] =  $r['areaId'];
		}
	}
	print json_encode($userData);
}

if(isset($_POST['supplierId'])){
	$inchargeId = $_POST['supplierId'];
	$seasonId = $_POST['seasonId'];

	$con = new HDatabase();
	$con->connect();
	$con->select('qa_area','areaId,areaName',"userId = '$inchargeId' AND season='$seasonId'");
	$result = $con->getResult();

	$i=0;	
	$detailArray = array();
	$areaNames = array();

	if($result){
		foreach ($result as $r){
			$areaId = $r['areaId'];
			$areaNames[$i][1] = $r['areaName'];
			$areaNames[$i][0] = $areaId;			
			
			$i++;
		}
		$detailArray = $areaNames;		
	}
	print json_encode($detailArray);
}

if(isset($_POST['supplier'])){
	$incharge = $_POST['supplier'];
	$project = $_POST['projectId'];
	$seasonId = $_POST['seasonId'];

	$db = new HDatabase();
	$db->connect();
	$db->select('qa_center','DISTINCT centerName',"areaId = '$project'");
	$res = $db->getResult();

	$j=0;
	$centerArray = array();
	if($res){
		foreach ($res as $rr){
			$centerName = $rr['centerName'];
				
			$db->resetResult();
			$db->select("qa_area",'cate_id',"areaId='$project'");
			$resultCat = $db->getResult();
				
			$cate_id = $resultCat[0]['cate_id'];

			$db->resetResult();
				
			if($cate_id == 5){
				$db->select('qa_centerQuantitySmall','center',"center='$centerName' AND id='$project'");
			}else{
				$db->select('qa_centerQuantity','center',"center='$centerName' AND id='$project'");
			}
				
			$centerResult = $db->getResult();
			if($centerResult){
				$centerArray[$j]= '<input type="checkbox" checked />'.$rr['centerName'];				
			}
			else{
				$centerArray[$j]= '<input type="checkbox" />'.$rr['centerName'];
			}
			$j++;
		}
	}else{
		$centerArray = null;
	}
	print json_encode($centerArray);
}

if(isset($_POST['gradeCat'])){
	$proId = $_POST['proId'];

	$db = new HDatabase();
	$db->connect();
	$db->select("qa_area",'cate_id',"areaId='$proId'");
	$res = $db->getResult();
	$catId = $res[0]['cate_id'];
	print $catId;
}

if(isset($_POST['selectedProject'])){
	$projectId = $_POST['selectedProject'];

	$conn= new HDatabase();
	$conn->connect();
	$conn->select('qa_area','cate_id',"areaId='$projectId'");
	$gradeCategoryRes = $conn->getResult();
	$gradeCategory = $gradeCategoryRes[0]['cate_id'];

	$db = new HDatabase();
	$db->connect();
	$db->select('qa_grade','gradeId,fruitCount',"cate_id='$gradeCategory'",'gradeId ASC');
	$gradeCategoryId = $gradeCategoryRes[0]['cate_id'];

	/*$conn->resetResult();
	 $conn->select('qa_gradeCategory',"name","id='$gradeCategoryId'");
	 $categories = $conn->getResult();
	 $gradeCategory = $categories[0]['name'];
	 */
	$db = new HDatabase();
	$db->connect();
	$db->select('qa_grade','gradeId,fruitCount',"cate_id='$gradeCategoryId'",'gradeId ASC');
	$resultNew = $db->getResult();

	$data = "";
	foreach ($resultNew as $r){
		$data .='<option value='.$r['gradeId'].'>'.$r['fruitCount'].'</option>';
			
	}
	$data .= '<option value="Total">Total</option>';

	$returnArr = array();
	$returnArr[0] = $data;
	$returnArr[1] = $gradeCategory;

	print json_encode($returnArr);
}
if(isset($_POST['graph2'])){
	$incharge = $_POST['supplierQuantity'];
	$project = $_POST['project'];
	$seasonId = $_POST['seasonId'];

	$dbDate = new HDatabase();
	$dbDate->connect();
	$dbDate->select('qa_seasons','*',"seasonId='$seasonId'");
	$dates = $dbDate->getResult();
	$startDate = $dates[0]['startDate']." 00:00:00";
	$endDate = $dates[0]['endDate']." 23:59:59";

	$DQ=0;
	$AQ=0;
	$PQ=0;
	settype($DQ,"double");
	settype($AQ,"double");
	settype($PQ,"double");

	$gradeCatCon = new HDatabase();
	$gradeCatCon->connect();
	$gradeCatCon->select('qa_area','gradeCategory',"areaId='$project'");
	$resGrade = $gradeCatCon->getResult();
	$grade = $resGrade[0]['gradeCategory'];

	$dataArray = array();

	if(isset($_POST['subGrade'])){
			
		$gradeId = $_POST['subGrade'];
			
		$con= new HDatabase();
		$con->connect();
		$con->select('qa_gradeStock','notedWeight,trueWeight,payableQuantity',"id='$project' AND gradeId='$gradeId' AND date>='$startDate' AND date<='$endDate'");
		$result = $con->getResult();
		//print_r($result);
			
		if($result){
			foreach ($result as $rr){
				$DQ+= $rr['notedWeight'];
				$AQ+= $rr['trueWeight'];
				$PQ+= $rr['payableQuantity'];
			}
		}
	}
	else{
		$db = new HDatabase();
		$db->connect();
		$db->select('qa_gradeStock','notedWeight,trueWeight,payableQuantity',"id='$project' AND date>='$startDate' AND date<='$endDate'");
		$res = $db->getResult();

		if($res){
			foreach ($res as $rr){
				$DQ+= $rr['notedWeight'];
				$AQ+= $rr['trueWeight'];
				$PQ+= $rr['payableQuantity'];
			}
		}
	}

	$dataArray[0] = $DQ;
	$dataArray[1] = $AQ;
	$dataArray[2] = $PQ;

	print json_encode($dataArray);
}

/*
 * setting arrival pattern graph
 * @author giya

 */
$totalData=array();

if(isset($_POST['flag'])){
	$flag=$_POST['flag'];
	if($flag=='genPattern'){

		$incharge = $_POST['supplierArrival'];
		$project = $_POST['project'];
		$seasonId = $_POST['seasonId'];

		/*
		 * getting the DB object
		 */
		$db = new HDatabase();
		$db->connect();
		$db->select("qa_area","cate_id","areaId='$project'");
		$res_project=$db->getResult();
		if($res_project){
			$cate=$res_project[0]['cate_id'];
		}
		//if subgrade is selected
		if(isset($_POST['subGrade'])){
			$gradeId = $_POST['subGrade'];

			$db->resetResult();
			$db->select('qa_arrivalData',
						'cropFrom,cropTo,quantity',
						"projectId='$project' AND gradeId='$gradeId' AND seasonId='$seasonId'","cropFrom ASC");

			$weeks=$db->getResult();

			if($weeks){
				$i=0;
				foreach ($weeks as $tmp_week){
					$totalData[$i]['from']=$tmp_week['cropFrom'];
					$totalData[$i]['to']=$tmp_week['cropTo'];
					$totalData[$i]['pattern_q']=$tmp_week['quantity'];
					$db->resetResult();
					//getting declared quantity for particular week

					/* checking project's grade */

					$db->select("qa_area","cate_id","areaId='$project'");
					$res_project=$db->getResult();
					if($res_project){
						$cate=$res_project[0]['cate_id'];
					}
					/*
					 * checking grade category
					 */

					$db->resetResult();
					if($cate!='5'){
						/*
						 * grade is not in small category.
						 */
						$db->select("qa_gradeStock","sum(notedWeight)",
									"id='$project' AND date>='".$tmp_week['cropFrom']."'
									 AND date<='".$tmp_week['cropTo']."' AND gradeId='$gradeId'");
						$temp_total=$db->getResult();
						if($temp_total){
							if($temp_total[0]['sum(notedWeight)']){
								$totalData[$i]['a_q']=round($temp_total[0]['sum(notedWeight)']/1000,2);
							}else{
								$totalData[$i]['a_q']=0;
							}

						}else{
							return false;
						}
					}else {

						/*
						 * for small category.
						 */
						$db->select("qa_small_crop","");
					}






					$i++;
				}
				//if current week is going beyond the last week of plan ,


				print json_encode($totalData);

			}else{
				//pattern data is not being set .shuld get actual quantity

				//get seasons first date
				$db->resetResult();
				$db->select("qa_seasons","*","flag='1'");
				$res=null;
				$res=$db->getResult();
				$str_date_season=$res[0]['startDate'];
				$weeks_array=array();
				/*
				 * sets the season start date as the first week date
				 */

				$week_start_date=$str_date_season;
				$today=date("Y-m-d");
				$i=0;
				while($week_start_date<$today){
					/* setting week end day*/
					$temp_firstEdit=strtotime($week_start_date);
					$newDate=mktime(0,0,0,date('m',$temp_firstEdit),date('d',$temp_firstEdit)+6,date('y',$temp_firstEdit));
					/* setting next week start day */
					$next_week_start=mktime(0,0,0,date('m',$temp_firstEdit),date('d',$temp_firstEdit)+7,date('y',$temp_firstEdit));
					$week_end_date=date('Y-m-d',$newDate);

					$weeks_array[$i]['from']=$week_start_date;
					$weeks_array[$i]['to']=$week_end_date;

					/*
					 * checking grade category
					 */
					if($cate!="5"){
						/* grade category is not small */
						$db->resetResult();
						$db->select("qa_gradeStock","sum(notedWeight)","id='$project' AND date>='".$weeks_array[$i]['from']."' AND date<='".$weeks_array[$i]['to']."' AND gradeId='$gradeId'");
						$res_temp=$db->getResult();
						/* there is a result */
						if($res_temp){
							if($res_temp[0]['sum(notedWeight)']){
								$weeks_array[$i]['a_q']=round($res_temp[0]['sum(notedWeight)']/1000,2);;
							}else{
								$weeks_array[$i]['a_q']=0;
							}


						}else{
							/* No result is found */
							$weeks_array[$i]['a_q']=0;
						}
					}else{
						/*
						 * grade category is small.Should qurery to small db tables.
						 */
						/*
						 * hard coding the small grades.
						 */

						$smallGrades=array('44'=>'11-14Q','45'=>'14-17Q','46'=>'17-29Q','47'=>'29-44Q','48'=>"crs");
						$db->resetResult();
						$db->select("qa_small_crop","sum('".$smallGrades[$gradeId]."')",
								"id='$project' AND date>='".$weeks_array[$i]['from']."' 
								AND date<='".$weeks_array[$i]['to']."'");

						$res_temp_small=$db->getResult();

						/* there is a result */
						if($res_temp_small){
							if($res_temp_small[0]["sum('".$smallGrades[$gradeId]."')"]!=null){
								//var_dump($res_temp_small[0]["sum('".$smallGrades[$gradeId]."')"]);
								$weeks_array[$i]['a_q']=round($res_temp_small[0]["sum('".$smallGrades[$gradeId]."')"]/1000,3);
							}else{
								$weeks_array[$i]['a_q']=0;
							}


						}else{
							/* No result is found */
							///	$weeks_array[$i]['a_q']=0;
						}
					}
					//getting stock data

					/* setting pattern quntity to 0 as arrival pattern is not set */
					$weeks_array[$i]['pattern_q']=0;
					$i++;
					$week_start_date=date('Y-m-d',$next_week_start);
				}

				print json_encode($weeks_array);
			}




		}else{
			//subgrade is not set
			//total quantity should be obtained

			$db->resetResult();
			$db->select("qa_arrivalData","sum(quantity) , cropFrom, cropTo",
						"projectId = '$project' AND seasonId =  '$seasonId'","",
						"cropFrom");
			$week_total=$db->getResult();
			if($week_total){
				$_totalData=array();
				$i=0;
				foreach ($week_total as $temp_week_total){

					$_totalData[$i]['from']= $temp_week_total['cropFrom'];
					$_totalData[$i]['to']= $temp_week_total['cropTo'];
					$_totalData[$i]['pattern_q']=$temp_week_total['sum(quantity)'];
					//getting actual quantity relavant to pattern weeks

					/*
					 * if gradeCatrgory is not small
					 */
					if($cate!=5){
						$db->resetResult();
						$db->select("qa_stock","sum(quantity)","id='$project' AND date>='".$temp_week_total['cropFrom']."' AND date<='".$temp_week_total['cropTo']."'");
						$r=$db->getResult();
						if($r[0]['sum(quantity)']!=null){
							$_totalData[$i]['a_q']=round($r[0]['sum(quantity)']/1000,2);
						}else {
							$_totalData[$i]['a_q']=0;
						}

					}else{
							
						/*
						 * grade category is small
						 */
						$db->resetResult();
						$db->select("qa_small_crop","sum(total_AQ)","id='$project' AND  date>='".$temp_week_total['cropFrom']."' AND date<='".$temp_week_total['cropTo']."'");
						$r2=$db->getResult();
						if($r2[0]['sum(total_AQ)']!=null){
							var_dump($r2[0]['sum(total_AQ)']);
							$_totalData[$i]['a_q']=round($r2[0]['sum(total_AQ)']/1000,3);
						}else{
							$_totalData[$i]['a_q']=0;
						}
					}


					$i++;
				}
				print json_encode($_totalData);
					
			}else{
				//pattern data is not being set. Actual quantities should be set
				/*
				*
				*/

				$db->resetResult();
				$db->select("qa_seasons","*","flag='1'");
				$res=null;
				$res=$db->getResult();
				$str_date_season=$res[0]['startDate'];
				$weeks_array=array();
				/*
				 * sets the season start date as the first week date
				 */
				$week_start_date=$str_date_season;
				$today=date("Y-m-d");
				$i=0;
				while($week_start_date<$today){
					/* setting week end day*/
					$temp_firstEdit=strtotime($week_start_date);
					$newDate=mktime(0,0,0,date('m',$temp_firstEdit),date('d',$temp_firstEdit)+6,date('y',$temp_firstEdit));
					/* setting next week start day */
					$next_week_start=mktime(0,0,0,date('m',$temp_firstEdit),date('d',$temp_firstEdit)+7,date('y',$temp_firstEdit));
					$week_end_date=date('Y-m-d',$newDate);

					$weeks_array[$i]['from']=$week_start_date;
					$weeks_array[$i]['to']=$week_end_date;
					//getting stock data
					$db->resetResult();
					/*
					 * if this is for non-small grade category.
					 */
					if($cate!=5){
						$db->select("qa_gradeStock","sum(notedWeight)","id='$project' AND date>='".$weeks_array[$i]['from']."' AND date<='".$weeks_array[$i]['to']."'");
						$res_temp=$db->getResult();
						/* there is a result */
						if($res_temp){
							if($res_temp[0]['sum(notedWeight)']){
								$weeks_array[$i]['a_q']=round($res_temp[0]['sum(notedWeight)']/1000,2);;
							}else{
								$weeks_array[$i]['a_q']=0;
							}


						}else{
							/* No result is found */
							$weeks_array[$i]['a_q']=0;
						}
					}else{
						/* Grade category is small */
						$db->resetResult();
						$db->select("qa_small_crop","sum(total_AQ)","id='$project' AND  date>='".$weeks_array[$i]['from']."' AND date<='".$weeks_array[$i]['to']."'");
						$r2=$db->getResult();
						if($r2[0]['sum(total_AQ)']!=null){

							$weeks_array[$i]['a_q']=round($r2[0]['sum(total_AQ)']/1000,3);
						}else{
							$weeks_array[$i]['a_q']=0;
						}

					}

					/* setting pattern quntity to 0 as arrival pattern is not set */
					$weeks_array[$i]['pattern_q']=0;
					$i++;
					$week_start_date=date('Y-m-d',$next_week_start);
				}
					
				print json_encode($weeks_array);


			}



		}





	}

}







/*
 * end of @author giya

 */

if(isset($_POST['graph44'])){
	/*
	 * getting post data
	 */
	$incharge = $_POST['supplierArrival'];
	$project = $_POST['project'];
	$seasonId = $_POST['seasonId'];

	$k=0;
	$quantity =array();
	$kMax =0;
	/*
	 * getting the DB object
	 */
	$db = new HDatabase();
	$db->connect();
	$db->select('qa_area','gradeCategory',"areaId='$project'");
	$resGradeCat = $db->getResult();
	$gradeCategory = $resGradeCat[0]['gradeCategory'];

	if(isset($_POST['subGrade'])){
		$gradeId = $_POST['subGrade'];

		$db->resetResult();
		//getting arrival pattern relavant to sub-grade acending order in cropFrom week
		$db->select('qa_arrivalData','cropFrom,cropTo,quantity',"projectId='$project' AND gradeId='$gradeId' AND seasonId='$seasonId'","cropFrom ASC");
		$resFdate = $db->getResult();

		//first week
		$first = $resFdate[0]['cropFrom'];
		//if arrival pattern is inserted ..do .. else , should display normal quantities
		if($resFdate){
			$arrivalQuantity = 0;
			$dateArray = "";
			foreach($resFdate as $r){
				$firstDateArray = explode("-",$r['cropFrom']);
				$endDateArray = explode("-",$r['cropTo']);

				$dateArray .= $firstDateArray['2']."-".$firstDateArray['1']."/".$endDateArray['2']."-".$endDateArray['1']."/".$firstDateArray['0']."^";
				$arrivalQuantity .= $r['quantity']."-";
			}

		}

			
	}else{
		//subgrade is not set.sum of All grades shoould be aquired
		$db->resetResult();
		$db->select('qa_arrivalData','DISTINCT weekNo',"projectId='$project' AND seasonId='$seasonId'","cropFrom ASC");
		$resFdate = $db->getResult();
		$firstWeek = $resFdate[0]['weekNo'];

		$abc = new WeekCounter();
		$firstWeekDates = $abc->getSeperateWeek($firstWeek);

		$first = $firstWeekDates[0];

		$dateArray = "";
			
		foreach ($resFdate as $rdate){
			$myWeek = $abc->getSeperateWeek($rdate['weekNo']);
			$firstDateArray = explode("-",$myWeek[0]);
			$endDateArray = explode("-",$myWeek[1]);

			$dateArray .= $firstDateArray['2']."-".$firstDateArray['1']."/".$endDateArray['2']."-".$endDateArray['1']."/".$firstDateArray['0']."^";

			$last = $myWeek[1];
		}
			
		$arrivalQuantity = 0;
		$weekQuantity = 0;

		//print $first."-".$last;
			
		while($first < $last){
			$firstEdit=strtotime($first);
			$newDate=mktime(0,0,0,date('m',$firstEdit),date('d',$firstEdit)+6,date('y',$firstEdit));
			$newFirstDate=date('Y-m-d',$newDate);

			//print $first.":";

			$getQuantity = new HDatabase();
			$getQuantity->connect();
			$getQuantity->select('qa_arrivalData','quantity',"projectId='$project' AND cropFrom>='$first' AND cropTo<='$newFirstDate' AND seasonId='$seasonId'","cropFrom ASC");
			$resQuantity = $getQuantity->getResult();

			if($resQuantity){
				foreach ($resQuantity as $rQuantity){
					$weekQuantity += $rQuantity['quantity'];
				}
			}else{
				$weekQuantity =0;
			}

			$preparedDate = strtotime($newFirstDate);
			$newFirstDate = mktime(0,0,0,date('m',$preparedDate),date('d',$preparedDate)+1,date('y',$preparedDate));
			$newFirstDate = date('Y-m-d',$newFirstDate);
			$first = $newFirstDate;
			$arrivalQuantity .= $weekQuantity."-";
			$weekQuantity=0;
		}
		$first = $firstWeekDates[0];
	}

	if($gradeCategory != "Small"){

		$dateCon =  new HDatabase();
		$dateCon->connect();
		$dateCon->select('qa_gradeStock','date','',"date ASC" );
		$resDate = $dateCon->getResult();
		$firstDate =  $resDate[0]['date'];

		foreach ($resDate as $rdate){
			$lastDate = $rdate['date'];
		}

		while($first<$lastDate){
			$firstEdit=strtotime($first);
			$newDate=mktime(0,0,0,date('m',$firstEdit),date('d',$firstEdit)+6,date('y',$firstEdit));
			$newFirstDate=date('Y-m-d',$newDate);

			if(isset($_POST['subGrade'])){
				$con = new HDatabase();
				$con->connect();
				$con->select('qa_gradeStock','notedWeight',"project='$project' AND gradeId='$gradeId' AND date>='$first' AND date<='$newFirstDate'");
				$result = $con->getResult();
			}else{
				$con = new HDatabase();
				$con->connect();
				$con->select('qa_gradeStock','notedWeight',"project='$project' AND date>='$first' AND date<='$newFirstDate'");
				$result = $con->getResult();
			}

			$quantity[$k] =0;
			if($result){
				foreach ($result as $rr){
					$quantity[$k] += $rr['notedWeight'];
				}
			}else{
				$quantity[$k] = 0;
			}
			$preparedDate = strtotime($newFirstDate);
			$newFirstDate = mktime(0,0,0,date('m',$preparedDate),date('d',$preparedDate)+1,date('y',$preparedDate));
			$newFirstDate = date('Y-m-d',$newFirstDate);
			$first = $newFirstDate;
			$k++;
		} // end of while loop

	}// end of checking small
	else{
		$getGrade = new HDatabase();
		$getGrade->connect();
		$getGrade->select('qa_grade','diameter',"gradeId='$subGrade' AND gradeCategory='$gradeCategory'");
		$getGradeRes = $getGrade->getResult();
		$diameter = $getGradeRes[0]['diameter'];

		$dateCon =  new HDatabase();
		$dateCon->connect();
		$dateCon->select('qa_small_belongs','date','',"date ASC" );
		$resDate = $dateCon->getResult();
		$firstDate =  $resDate[0]['date'];

		foreach ($resDate as $rdate){
			$lastDate = $rdate['date'];
		}

		while($first<$lastDate){
			$firstEdit=strtotime($first);
			$newDate=mktime(0,0,0,date('m',$firstEdit),date('d',$firstEdit)+6,date('y',$firstEdit));
			$newFirstDate=date('Y-m-d',$newDate);

			if(isset($_POST['subGrade'])){
				$con = new HDatabase();
				$con->connect();
				$con->select('qa_small_belongs','DQ',"project='$project' AND gradeName='$diameter' AND date>='$first' AND date<='$newFirstDate'");
				$result = $con->getResult();
			}else{
				$con = new HDatabase();
				$con->connect();
				$con->select('qa_small_belongs','DQ',"project='$project' AND date>='$first' AND date<='$newFirstDate'");
				$result = $con->getResult();
			}

			$quantity[$k] =0;
			if($result){
				foreach ($result as $rr){
					$quantity[$k] += $rr['DQ'];
				}
			}else{
				$quantity[$k] = 0;

			}

			$preparedDate = strtotime($newFirstDate);
			$newFirstDate = mktime(0,0,0,date('m',$preparedDate),date('d',$preparedDate)+1,date('y',$preparedDate));
			$newFirstDate = date('Y-m-d',$newFirstDate);
			$first = $newFirstDate;
			$k++;
		}
			
			
	}

	$kMax = $k;

	$finalData = 0;
	for($i=0;$i<$kMax;$i++){
		$finalData .= $quantity[$i]."-";
	}
	echo $finalData.":".$arrivalQuantity.":".$dateArray;
}

if(isset($_POST['graph3'])){
	$incharge = $_POST['supplierDefects'];
	$project = $_POST['project'];
	$seasonId = $_POST['seasonId'];

	$dbDate = new HDatabase();
	$dbDate->connect();
	$dbDate->select('qa_seasons','*',"seasonId='$seasonId'");
	$dates = $dbDate->getResult();
	$startDate = $dates[0]['startDate']." 00:00:00";
	$endDate = $dates[0]['endDate']." 23:59:59";

	$j=0;
	$quantityArray = array();
	$defectQuantity = array();
	$defects = array('sumOfSmallFruit','sumOfLargeFruit','sumOfFlyAttacked','sumOfPeeledOff','sumOfBoreAttacked','sumOfSandEmbedded','sumOfShrivelled','sumOfDeformed','sumOfVirusAttacked','sumOfMechanicalDamaged','sumOfYellowish','sumOfRustPatches','sumOfRotten','sumOf45');

	for($k=0;$k<count($defects);$k++){
		$defectQuantity[$k] =0;
	}

	$gradeCatCon = new HDatabase();
	$gradeCatCon->connect();
	$gradeCatCon->select('qa_area','cate_id',"areaId='$project'");
	$resGrade = $gradeCatCon->getResult();
	$grade = $resGrade[0]['cate_id'];

	if(isset($_POST['subGrade'])){
		$gradeId = $_POST['subGrade'];
		$db1 = new HDatabase();
		$db1->connect();
		$db1->select('qa_grade','sampleWeight',"gradeId='$gradeId' AND cate_id='$grade'");
		$res1 = $db1->getResult();

		$sampleWeight = $res1[0]['sampleWeight'];

		$dbNew = new HDatabase();
		$dbNew->connect();
		$dbNew->select('qa_gradeStock','*',"id='$project' AND gradeId='$gradeId' AND date>='$startDate' AND date<='$endDate'","date,vehicleNo ASC");
		$resultDefects = $dbNew->getResult();

		if($resultDefects){
			foreach ($resultDefects as $res){
				$totalFruits = $sampleWeight * $res['fruitCount'];

				for($k=0;$k<count($defects);$k++){
					$defectQuantity[$j] += ($res[$defects[$k]]/$totalFruits)* 100;
					$j++;
				}
				$j=0;
			}

			for($k=0;$k<count($defects);$k++){
				$quantityArray[$k] = $defectQuantity[$j]/count($resultDefects);
				$j++;
			}

		}
	}

	/*getting total values */
	else{

		$connect = new HDatabase();
		$connect->connect();
		$connect->select('qa_gradeStock','*',"date>='$startDate' AND date<='$endDate' AND id='$project'","date,vehicleNo ASC");
		$res = $connect->getResult();

		$oldNo = "";
		$oldDate = "";

		$currCount = 1;
		$finalValue=array();
		$arrCount = 0;

		$defectQuantity = array();

		for($k=0;$k<count($defects);$k++){
			$defectQuantity[$k] =0;
			$finalValue[$k] = 0;
		}

		$c = 1;

		foreach ($res as $rr){
			$vehicleNo = $rr['vehicleNo'];
			$date = $rr['date'];

			$connect->resetResult();
			$connect->select('qa_area','cate_id',"areaId='$project'");
			$resGrade = $connect->getResult();
			$grade = $resGrade[0]['cate_id'];

			$gradeId = $rr['gradeId'];
			$connect->resetResult();
			$connect->select('qa_grade','sampleWeight',"gradeId='$gradeId' AND cate_id='$grade'");
			$res1 = $connect->getResult();

			$sampleWeight = $res1[0]['sampleWeight'];
			$totalFruit = $sampleWeight * $rr['fruitCount'];

			if($c != 1){
				if($vehicleNo == $oldNo && $date == $oldDate ){
					for($i=0;$i<count($defects);$i++){
						$defectQuantity[$i] += ($rr[$defects[$i]]/$totalFruit)*100;
					}
					$currCount++;
				}else{
					for($j=0;$j<count($defects);$j++){
						$finalValue[$j] += $defectQuantity[$j]/$currCount;
					}

					for($i=0;$i<count($defects);$i++){
						$defectQuantity[$i] = ($rr[$defects[$i]]/$totalFruit)*100;
					}

					$oldNo = $rr['vehicleNo'];
					$oldDate = $rr['date'];
					$currCount = 1;
					$arrCount++;
				}
					
			}else{
				$oldNo = $rr['vehicleNo'];
				$oldDate = $rr['date'];

				for($i=0;$i<count($defects);$i++){
					$defectQuantity[$i] = ($rr[$defects[$i]]/$totalFruit)*100;
				}
				$c++;
					
			}

		}

		if(!empty($finalValue)){
			for($j=0;$j<count($defects);$j++){
				$quantityArray[$j] = ($finalValue[$j] + $defectQuantity[$j]/$currCount)/($arrCount+1) ;
			}
		}else{
			for($i=0;$i<count($defects);$i++){
				$quantityArray[$i] = $defectQuantity[$i]/$currCount;
			}
		}

	}/* end of getting total values */

	print json_encode($quantityArray);

}

if(isset($_POST['graph2Small'])){
	$incharge = $_POST['supplierQuantity'];
	$project = $_POST['project'];
	$seasonId = $_POST['seasonId'];

	$DQ=0;
	$AQ=0;
	$PQ=0;
	settype($DQ,"double");
	settype($AQ,"double");
	settype($PQ,"double");

	$gradeCatCon = new HDatabase();
	$gradeCatCon->connect();
	$gradeCatCon->select('qa_area','cate_id',"areaId='$project'");
	$resGrade = $gradeCatCon->getResult();
	$grade = $resGrade[0]['cate_id'];

	$db = new HDatabase();
	$db->connect();
	$db->select('qa_area','areaId',"inchargeName='$incharge'");
	$res = $db->getResult();

	$returnArray = array();

	if(isset($_POST['subGrade'])){
			
		$gradeId = $_POST['subGrade'];
		$db1 = new HDatabase();
		$db1->connect();
		$db1->select('qa_grade','diameter',"gradeId='$gradeId' AND cate_id='$grade'");
		$res1 = $db1->getResult();
		$diameter = $res1[0]['diameter'];
			
		$con= new HDatabase();
		$con->connect();
		$con->select('qa_small_belongs','*',"id='$project' AND gradeName='$diameter'");
		$result = $con->getResult();
		//print_r($result);
			
		if($result){
			foreach ($result as $rr){
				$DQ+= $rr['DQ'];
				$AQ+= $rr['AQ'];
				$PQ+= $rr['11-14'] + $rr['14-17'] + $rr['17-29'] + $rr['29-44'] + $rr['CRS'] ;
			}
		}
	}
	else{
		$db = new HDatabase();
		$db->connect();
		$db->select('qa_small_belongs','*',"id='$project'");
		$res = $db->getResult();

		if($res){
			foreach ($res as $rr){
				$DQ+= $rr['DQ'];
				$AQ+= $rr['AQ'];
				$PQ+= $rr['11-14'] + $rr['14-17'] + $rr['17-29'] + $rr['29-44'] + $rr['CRS'] ;
			}

		}
	}
	$returnArray[0] = $DQ;
	$returnArray[1] = $AQ;
	$returnArray[2] = $PQ;
	print json_encode($returnArray);
}
if(isset($_POST['graph3Small'])){
	$incharge = $_POST['supplierQuantity'];
	$project = $_POST['project'];
	$seasonId = $_POST['seasonId'];
	$total = $_POST['Total'];
	$j = 0;
	$fruitCount = "";

	$defects = array('smallFruit','largeFruit','melonFlyAttack','peeledOff','boreAttacked','sandEmbedded','shrivelled','mechanicalDamaged','yellowish','RustPatches','spoiled');
	$defectQuantity = array();
	for($k=0;$k<count($defects);$k++){
		$defectQuantity[$k] =0;
	}

	$con= new HDatabase();
	$con->connect();

	if($total == "0"){
		$gradeId = $_POST['subGrade'];
			
		$con->select('qa_grade','fruitCount',"gradeId='$gradeId'");
		$fcRes = $con->getResult();
		$fruitCount = $fcRes[0]['fruitCount'];
	}
	if($fruitCount == "CRS" || $total == "1" ){

		$con->resetResult();
		$con->select('qa_small_crsData','*',"id='$project'");
		$result = $con->getResult();

		$resultCount = 0;

		if($result){
			foreach ($result as $res){
				for($k=0;$k<count($defects);$k++){
					$arr = explode("-", $res[$defects[$k]]);

					if(isset($arr)){
						$defectQuantity[$j] += $arr[1];
					}else{
						$defectQuantity[$j] += 0;
					}
					$j++;
				}
				$j = 0;
				$resultCount++;
			}
				
			if($resultCount > 0){
				for($k=0;$k<count($defects);$k++){
					$defectQuantity[$k] = $defectQuantity[$k]/$resultCount;
				}
			}
		}
	}
	print json_encode($defectQuantity);
}
if(isset($_POST['gradeIdForName'])){
	$gradeId = 	$_POST['gradeIdForName'];

	$con = new HDatabase();
	$con->connect();
	$con->select('qa_grade',"fruitCount","gradeId='$gradeId'");
	$res = $con->getResult();
	$gradeFC = $res[0]['fruitCount'];

	print $gradeFC;
}

//getting the season end date

if(isset($_POST['flag'])){
	$flag=$_POST['flag'];
	if($flag=="getSeason"){
		$seasonId=$_POST['sid'];
		$s=new Season();
		$season=$s->getSeasonData($seasonId);
		$endDate=$season[0]['endDate'];

		print json_encode(array("status"=>"true","endDate"=>$endDate));
	}else{

	}

}

class WeekCounter{
	function getSeperateWeek($week){
		$sp1=explode("/", $week);
		$y=$sp1[2];
		$s1=explode("-",$sp1[0]);
		$fd=$s1[0];
		// if($fd<10)$fd1="0".$fd;else $fd1=$fd;
		$fm=$s1[1];
		///if($fm<10)$fm1="0".$fm;else $fm1=$fm;
		$s2=explode("-",$sp1[1]);

		$ld=$s2[0];
		//if($ld<10)$ld1="0".$ld;else $ld1=$ld;
		$lm=$s2[1];
		// if($lm<10)$lm1="0".$lm;else $lm1=$lm;
		$week_ret=array();
		$week_ret[0]=date($y."-".$fm."-".$fd);
		$week_ret[1]=date( $y."-".$lm."-".$ld);

		return $week_ret;
	}

}




?>