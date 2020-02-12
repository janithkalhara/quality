<?php

require_once '../../includes/HDatabase.php';
require_once '../../libraries/base/season/lib_season.php';

if(isset($_POST['suppliers'])){

	$con = new HDatabase();
	$con->connect();
	$con->select('qa_area','Distinct areaName,userId,gradeCategory,inchargeName');
	//$result = array_unique($con->getResult(),SORT_REGULAR);
	$result = $con->getResult();
	
	$con1 = new HDatabase();
	$con1->connect();
	$con1->select('qa_seasons','seasonName,seasonId');
	$sea = $con1->getResult();

	$seasons = "<option>Select season</option>";
	foreach ($sea as $s){
		$seasons .= '<option value="'.$s['seasonId'].'" >'.$s['seasonName'].'</option>';
	}

	echo '<h2 style="position: relative;left: 90px">Registered Suppliers</h2>';

	//viewing supplier names
	foreach ($result as $r){
		echo '<img src="images/arrow.jpg" width="20px" height="17px" class="imgDiv" /><p class="supplierNames" onclick=dropDown("dropdown'.$r['userId'].'") >
			&nbsp;&nbsp;&nbsp;'.$r['inchargeName'].'</p>
			<div id="dropdown'.$r['userId'].'" class="dropDownMenu" >
			<select onchange="showProfile(\''.$r['gradeCategory'].'\',\''.$r['userId'].'\',\''.$r['inchargeName'].'\',this.options[selectedIndex].value)" >'
			.$seasons.
			'</select>			
			</div>';
	}
}

if(isset($_POST['userId'])){
	$userId = $_POST['userId'];

	$conn = new HDatabase();
	$conn->connect();
	$conn->select('qa_user','*',"userId='$userId'");
	$res = $conn->getResult();

	$avatar = "";
	$address="";
	foreach ($res as $r){
		$avatar = $r['avatar'];
		$area = $r['areaId'];
	}
	echo $avatar."-".$area;
}
if(isset($_POST['supplierName'])){
	$inchargeName = $_POST['supplierName'];
	$seasonId = $_POST['seasonId'];

	$con = new HDatabase();
	$con->connect();
	$con->select('qa_area','areaId,areaName',"inchargeName = '$inchargeName'");
	$result = $con->getResult();

	$gradeCategories = "";
	$centerArray = "";
	$detailArray = "";
	$areaNames = "";
	foreach ($result as $r){
		$areaId = $r['areaId'];
		$areaNames .= $r['areaName'].":";

		$db = new HDatabase();
		$db->connect();
		$db->select('qa_center','centerName',"areaId = '$areaId'");
		$res = $db->getResult();

		foreach ($res as $rr){
			$centerName = $rr['centerName'];
			$centerCon = new HDatabase();
			$centerCon->connect();
			$centerCon->select('qa_center_fakes','centerName',"centerName='$centerName' AND seasonId='$seasonId'");
			$centerResult = $centerCon->getResult();
			if($centerResult){
				$centerArray.= '<input type="checkbox" checked />'.$rr['centerName']."_";
			}
			else{
				$centerArray.= '<input type="checkbox" />'.$rr['centerName']."_";
			}

		}

		$centerArray.=":";

	}

	$connect = new HDatabase();
	$connect->connect();
	$connect->select('qa_user','*',"");


	echo $areaNames.";".$centerArray;
}

if(isset($_POST['supplier'])){
	$incharge = $_POST['supplier'];
	$project = $_POST['grade'];
	$seasonId = $_POST['seasonId'];

	$db = new HDatabase();
	$db->connect();
	$db->select('qa_area','areaId',"inchargeName='$incharge' AND areaName='$project'");
	$result = $db->getResult();

	$areaId = $result[0]['areaId'];
	$db1 = new HDatabase();
	$db1->connect();
	$db1->select('qa_center','centerName,centerId',"areaId='$areaId'");
	$res = $db1->getResult();

	foreach ($res as $r){
		$centerName = $r['centerName'];
		$centerCon = new HDatabase();
		$centerCon->connect();
		$centerCon->select('qa_center_fakes','centerName',"centerName='$centerName' AND seasonId='$seasonId'");
		$centerResult = $centerCon->getResult();
		if($centerResult){
			$centerName = $r['centerName'];
			echo '<li><input type="checkbox" checked />'.$r['centerName'].'</li>';
		}
		else{
			$centerName = $r['centerName'];
			echo '<li><input type="checkbox" />'.$r['centerName'].'</li>';
		}
	}
}

if(isset($_POST['gradeCategory'])){
	$projectName = $_POST['gradeCategory'];

	$conn= new HDatabase();
	$conn->connect();
	$conn->select('qa_area','gradeCategory',"areaName='$projectName'");
	$gradeCategoryRes = $conn->getResult();
	$gradeCategory = $gradeCategoryRes[0]['gradeCategory'];

	$db = new HDatabase();
	$db->connect();
	$db->select('qa_grade','fruitCount',"gradeCategory='$gradeCategory'",'gradeId ASC');
	$resultNew = $db->getResult();

	$data = "";
	foreach ($resultNew as $r){
		$data .='<option value='.$r['fruitCount'].'>'.$r['fruitCount'].'</option>';
			
	}
	$data .= '<option value="Total">Total</option>';
	echo $data;
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
	$gradeCatCon->select('qa_area','gradeCategory',"areaName='$project'");
	$resGrade = $gradeCatCon->getResult();
	$grade = $resGrade[0]['gradeCategory'];

	$db = new HDatabase();
	$db->connect();
	$db->select('qa_area','areaId',"inchargeName='$incharge'");
	$res = $db->getResult();

	if(isset($_POST['subGrade'])){
			
		$subGrade = $_POST['subGrade'];
		$db1 = new HDatabase();
		$db1->connect();
		$db1->select('qa_grade','gradeId',"fruitCount='$subGrade' AND gradeCategory='$grade'");
		$res1 = $db1->getResult();
		$gradeId = $res1[0]['gradeId'];
							
		$con= new HDatabase();
		$con->connect();
		$con->select('qa_gradeStock','notedWeight,trueWeight,payableQuantity',"project='$project' AND gradeId='$gradeId' AND date>='$startDate' AND date<='$endDate'");
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
		$db->select('qa_gradeStock','notedWeight,trueWeight,payableQuantity',"project='$project' AND date>='$startDate' AND date<='$endDate'");
		$res = $db->getResult();

		foreach ($res as $rr){
			$DQ+= $rr['notedWeight'];
			$AQ+= $rr['trueWeight'];
			$PQ+= $rr['payableQuantity'];
		}
			
	}
	echo $DQ.":".$AQ.":".$PQ;
}

if(isset($_POST['graph1'])){
	$incharge = $_POST['supplierArrival'];
	$project = $_POST['project'];
	$seasonId = $_POST['seasonId'];

	$k=0;
	$quantity =array();
	$kMax =0;

	$conn = new HDatabase();
	$conn->connect();
	$conn->select('qa_area','gradeCategory',"areaName='$project'");
	$resGradeCat = $conn->getResult();
	$gradeCategory = $resGradeCat[0]['gradeCategory'];

	if(isset($_POST['subGrade'])){
		$subGrade = $_POST['subGrade'];
		$getGrade = new HDatabase();
		$getGrade->connect();
		$getGrade->select('qa_grade','gradeId',"fruitCount='$subGrade' AND gradeCategory='$gradeCategory'");
		$getGradeRes = $getGrade->getResult();
		$gradeId = $getGradeRes[0]['gradeId'];

		$getFdate = new HDatabase();
		$getFdate->connect();
		$getFdate->select('qa_arrivalData','cropFrom,cropTo,quantity',"project='$project' AND gradeId='$gradeId' AND seasonId='$seasonId'","cropFrom ASC");
		$resFdate = $getFdate->getResult();
		$first = $resFdate[0]['cropFrom'];
		
		$arrivalQuantity = 0;
		$dateArray = "";
		foreach($resFdate as $r){
			$firstDateArray = explode("-",$r['cropFrom']);
			$endDateArray = explode("-",$r['cropTo']);
			
			$dateArray .= $firstDateArray['2']."-".$firstDateArray['1']."/".$endDateArray['2']."-".$endDateArray['1']."/".$firstDateArray['0']."^";
			$arrivalQuantity .= $r['quantity']."-";
		}
			
	}else{
		$getFdate = new HDatabase();
		$getFdate->connect();
		$getFdate->select('qa_arrivalData','DISTINCT weekNo',"project='$project' AND seasonId='$seasonId'","cropFrom ASC");
		$resFdate = $getFdate->getResult();
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
			$getQuantity->select('qa_arrivalData','quantity',"project='$project' AND cropFrom>='$first' AND cropTo<='$newFirstDate' AND seasonId='$seasonId'","cropFrom ASC");
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
		$getGrade->select('qa_grade','diameter',"fruitCount='$subGrade' AND gradeCategory='$gradeCategory'");
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
	$defectQuantity = array();
	$defects = array('sumOfSmallFruit','sumOfLargeFruit','sumOfFlyAttacked','sumOfPeeledOff','sumOfBoreAttacked','sumOfSandEmbedded','sumOfShrivelled','sumOfDeformed','sumOfVirusAttacked','sumOfMechanicalDamaged','sumOfYellowish','sumOfRustPatches');

	for($k=0;$k<count($defects);$k++){
		$defectQuantity[$k] =0;
	}

	$gradeCatCon = new HDatabase();
	$gradeCatCon->connect();
	$gradeCatCon->select('qa_area','gradeCategory',"areaName='$project'");
	$resGrade = $gradeCatCon->getResult();
	$grade = $resGrade[0]['gradeCategory'];

	if(isset($_POST['subGrade'])){
		$subGrade = $_POST['subGrade'];
		$db1 = new HDatabase();
		$db1->connect();
		$db1->select('qa_grade','gradeId,sampleWeight',"fruitCount='$subGrade' AND gradeCategory='$grade'");
		$res1 = $db1->getResult();
		$gradeId = $res1[0]['gradeId'];
		$sampleWeight = $res1[0]['sampleWeight'];

		$dbNew = new HDatabase();
		$dbNew->connect();
		$dbNew->select('qa_gradeStock','*',"project='$project' AND gradeId='$gradeId' AND date>='$startDate' AND date<='$endDate'");
		$resultDefects = $dbNew->getResult();

		if($resultDefects){
			foreach ($resultDefects as $res){
				$totalFruits = $sampleWeight * $res['fruitCount'];

				for($k=0;$k<count($defects);$k++){
					$defectQuantity[$j] += $res[$defects[$k]]/$totalFruits* 100;
					$j++;
				}
				$j=0;
			}
		}
	}

	else{
		$db1 = new HDatabase();
		$db1->connect();
		$db1->select('qa_grade','gradeId,sampleWeight',"gradeCategory='$grade'");
		$res1 = $db1->getResult();
			
		foreach ($res1 as $r1){
			$gradeId = $r1['gradeId'];
			$sampleWeight = $r1['sampleWeight'];

			$dbNew = new HDatabase();
			$dbNew->connect();
			$dbNew->select('qa_gradeStock','*',"project='$project' AND gradeId='$gradeId' AND date>='$startDate' AND date<='$endDate'");
			$resultDefects = $dbNew->getResult();

			if($resultDefects){
				foreach ($resultDefects as $res){
					$totalFruits = $sampleWeight * $res['fruitCount'];
					for($k=0;$k<count($defects);$k++){
						$defectQuantity[$j] += $res[$defects[$k]]/$totalFruits* 100;
						$j++;
					}
					$j=0;
				}
			}
		}

	}

	$dbNew->resetResult();
	$dbNew->select('qa_gradeStock','distinct gradeId',"project='$project'");
	$noOfGrades = count($dbNew->getResult());

	for($k=0;$k<count($defects);$k++){
		echo $defectQuantity[$j]/$noOfGrades."-";
		$j++;
	}
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
	$gradeCatCon->select('qa_area','gradeCategory',"areaName='$project'");
	$resGrade = $gradeCatCon->getResult();
	$grade = $resGrade[0]['gradeCategory'];

	$db = new HDatabase();
	$db->connect();
	$db->select('qa_area','areaId',"inchargeName='$incharge'");
	$res = $db->getResult();

	if(isset($_POST['subGrade'])){
			
		$subGrade = $_POST['subGrade'];
		$db1 = new HDatabase();
		$db1->connect();
		$db1->select('qa_grade','gradeId,diameter',"fruitCount='$subGrade' AND gradeCategory='$grade'");
		$res1 = $db1->getResult();
		$gradeId = $res1[0]['gradeId'];
		$diameter = $res1[0]['diameter'];

			
		$con= new HDatabase();
		$con->connect();
		$con->select('qa_small_belongs','*',"project='$project' AND gradeName='$diameter'");
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
		$db->select('qa_small_belongs','*',"project='$project'");
		$res = $db->getResult();

		foreach ($res as $rr){
			$DQ+= $rr['DQ'];
			$AQ+= $rr['AQ'];
			$PQ+= $rr['11-14'] + $rr['14-17'] + $rr['17-29'] + $rr['29-44'] + $rr['CRS'] ;
		}
			
	}
	echo $DQ.":".$AQ.":".$PQ;
}
if(isset($_POST['graph3Small'])){
	$incharge = $_POST['supplierQuantity'];
	$project = $_POST['project'];
	$seasonId = $_POST['seasonId'];
	$j = 0;
	$defects = array('smallFruit','largeFruit','melonFlyAttack','peeledOff','boreAttacked','sandEmbedded','shrivelled','mechanicalDamaged','yellowish','RustPatches','spoiled');

	$defectQuantity = array();
	for($k=0;$k<count($defects);$k++){
		$defectQuantity[$k] =0;
	}

	$con= new HDatabase();
	$con->connect();
	$con->select('qa_small_crsData','*',"project='$project'");
	$result = $con->getResult();

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
		}
	}

	for($k=0;$k<count($defects);$k++){
		echo $defectQuantity[$j]."-";
		$j++;
	}
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
		print json_encode(array("status"=>"false","error"=>"Wrong ajax call"));
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