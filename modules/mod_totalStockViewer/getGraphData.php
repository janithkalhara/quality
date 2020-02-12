<?php

require_once '../../includes/HDatabase.php';

require_once '../../libraries/base/project/lib_project.php';

require_once '../../libraries/base/season/lib_season.php';

$db = new HDatabase();
$db->connect();
$db->select('qa_seasons','*',"flag='1'");
$dbRes = $db->getResult();
$startDate = $dbRes[0]['startDate'];
$endDate = $dbRes[0]['endDate'];

$startDate .= " 00:00:00";
$endDate .= " 23:59:59";

$proObj = new Project();

if(isset($_POST['graph1'])){

	$con = new HDatabase();
	$con->connect();
	$con->select('qa_gradeStock','*',"date>='$startDate' AND date<='$endDate'");
	$result = $con->getResult();

	$con->resetResult();
	$con->select('qa_small_belongs','*',"date>='$startDate' AND date<='$endDate'");
	$resultSmall = $con->getResult();

	$DQ=0;
	$AQ=0;
	$PQ=0;
	settype($DQ,"double");
	settype($AQ,"double");
	settype($PQ,"double");

	if($result){
		foreach ($result as $r){
			$areaId = $r['id'];
			$proType = $proObj->getProTypeById($areaId);

			if($proType == "0"){
				$DQ +=$r['notedWeight'];
				$AQ +=$r['trueWeight'];
				$PQ +=$r['payableQuantity'];
			}
		}
	}

	if($resultSmall){
		foreach ($resultSmall as $s){
			$areaId = $s['id'];
			$proType = $proObj->getProTypeById($areaId);

			if($proType == "0"){
				$DQ +=$s['DQ'];
				$AQ +=$s['AQ'];
				$PQ +=$s['11-14'] + $s['14-17'] + $s['17-29'] + $s['29-44'] + $s['CRS'] ;
			}
		}
	}

	$data = array();
	$data[0] = $DQ;
	$data[1] = $AQ;
	$data[2] = $PQ;

	print json_encode($data);

}

if(isset($_POST['graph1EX'])){

	$con = new HDatabase();
	$con->connect();
	$con->select('qa_gradeStock','*',"date>='$startDate' AND date<='$endDate'");
	$result = $con->getResult();

	$con->resetResult();
	$con->select('qa_small_belongs','*',"date>='$startDate' AND date<='$endDate'");
	$resultSmall = $con->getResult();

	$DQ=0;
	$AQ=0;
	$PQ=0;
	settype($DQ,"double");
	settype($AQ,"double");
	settype($PQ,"double");

	if($result){
		foreach ($result as $r){
			$areaId = $r['id'];
			$proType = $proObj->getProTypeById($areaId);

			if($proType == "1"){
				$DQ +=$r['notedWeight'];
				$AQ +=$r['trueWeight'];
				$PQ +=$r['payableQuantity'];
			}
		}
	}

	if($resultSmall){
		foreach ($resultSmall as $d){
			$areaId = $d['id'];
			$proType = $proObj->getProTypeById($areaId);

			if($proType == "1"){
				$DQ +=$d['DQ'];
				$AQ +=$d['AQ'];
				$PQ +=$d['11-14'] + $d['14-17'] + $d['17-29'] + $d['29-44'] + $d['CRS'] ;
			}
		}
	}
	$data = array();
	$data[0] = $DQ;
	$data[1] = $AQ;
	$data[2] = $PQ;

	print json_encode($data);

}

if(isset($_POST['graph1Tot'])){

	$con = new HDatabase();
	$con->connect();
	$con->select('qa_gradeStock','*',"date>='$startDate' AND date<='$endDate'");
	$result = $con->getResult();

	$con->resetResult();
	$con->select('qa_small_belongs','*',"date>='$startDate' AND date<='$endDate'");
	$resultSmall = $con->getResult();

	$DQ=0;
	$AQ=0;
	$PQ=0;
	settype($DQ,"double");
	settype($AQ,"double");
	settype($PQ,"double");

	if($result){
		foreach ($result as $r){
			$DQ +=$r['notedWeight'];
			$AQ +=$r['trueWeight'];
			$PQ +=$r['payableQuantity'];
		}
	}

	if($resultSmall){
		foreach ($resultSmall as $p){
			$DQ +=$p['DQ'];
			$AQ +=$p['AQ'];
			$PQ +=$p['11-14'] + $p['14-17'] + $p['17-29'] + $p['29-44'] + $p['CRS'] ;
		}
	}

	$data = array();
	$data[0] = $DQ;
	$data[1] = $AQ;
	$data[2] = $PQ;

	print json_encode($data);

}

if(isset($_POST['graph3'])){
	$connect = new HDatabase();
	$connect->connect();
	$connect->select('qa_gradeStock','*',"date>='$startDate' AND date<='$endDate'","date,vehicleNo ASC");
	$res = $connect->getResult();
	$oldId = "";
	$oldNo = "";
	$oldDate = "";
	$currCount = 1;
	$finalValue=array();
	$arrCount = 0;

	$defects = array('sumOfSmallFruit','sumOfLargeFruit','sumOfFlyAttacked','sumOfPeeledOff',
	'sumOfBoreAttacked','sumOfSandEmbedded','sumOfShrivelled','sumOfDeformed','sumOfVirusAttacked',
	'sumOfMechanicalDamaged','sumOfYellowish','sumOfRustPatches','sumOfRotten','sumOf45');

	$defectQuantity = array();
	for($k=0;$k<count($defects);$k++){
		$defectQuantity[$k] =0;
		$finalValue[$k] = 0;
	}
	$c = 1;
	foreach ($res as $rr) {
		$areaId = $rr['id'];
		$proType = $proObj->getProTypeById($areaId);

		if($proType == "0") {
			$vehicleNo = $rr['vehicleNo'];
			$date = $rr['date'];
			$connect->resetResult();
			$connect->select('qa_area','cate_id',"areaId='$areaId'");
			$resGrade = $connect->getResult();
			$grade = $resGrade[0]['cate_id'];
			$gradeId = $rr['gradeId'];
			$connect->resetResult();
			$connect->select('qa_grade','sampleWeight',"gradeId='$gradeId' AND cate_id='$grade'");
			$res1 = $connect->getResult();

			$sampleWeight = $res1[0]['sampleWeight'];
			$totalFruit = $sampleWeight * $rr['fruitCount'];

			if($c != 1) {
				if($areaId == $oldId && $vehicleNo == $oldNo && $date == $oldDate ) {
					for($i=0;$i<count($defects);$i++) {
						$defectQuantity[$i] += ($rr[$defects[$i]]/$totalFruit)*100;
					}
					$currCount++;
				}
				else {
					for($j=0;$j<count($defects);$j++){
						$finalValue[$j] += $defectQuantity[$j]/$currCount;
					}

					for($i=0;$i<count($defects);$i++){
						$defectQuantity[$i] = ($rr[$defects[$i]]/$totalFruit)*100;
					}
						
					$oldId = $rr['id'];
					$oldNo = $rr['vehicleNo'];
					$oldDate = $rr['date'];
					$currCount = 1;
					$arrCount++;
				}

			}
			else {
				$oldId = $rr['id'];
				$oldNo = $rr['vehicleNo'];
				$oldDate = $rr['date'];

				for($i=0;$i<count($defects);$i++){
					$defectQuantity[$i] = ($rr[$defects[$i]]/$totalFruit)*100;
				}
				$c++;

			}
		}
	}
		$lastValueSet = array();
			
		if(!empty($finalValue)) {
			for($j=0;$j<count($defects);$j++) {
				$lastValueSet[$j] = ($finalValue[$j] + $defectQuantity[$j]/$currCount)/($arrCount+1) ;
			}
		}
		else {
			for($i=0;$i<count($defects);$i++){
				$lastValueSet[$i] = $defectQuantity[$i]/$currCount;
			}	
		}
	header('Content-type:/application/json');
	print json_encode($lastValueSet);
}

if(isset($_POST['graph3EX'])){

	$connect = new HDatabase();
	$connect->connect();
	$connect->select('qa_gradeStock','*',"date>='$startDate' AND date<='$endDate'","date,vehicleNo ASC");
	$res = $connect->getResult();
	$oldId = "";
	$oldNo = "";
	$oldDate = "";

	$currCount = 1;
	$finalValue=array();
	$arrCount = 0;

	$defects = array('sumOfSmallFruit','sumOfLargeFruit','sumOfFlyAttacked','sumOfPeeledOff',
	'sumOfBoreAttacked','sumOfSandEmbedded','sumOfShrivelled','sumOfDeformed','sumOfVirusAttacked',
	'sumOfMechanicalDamaged','sumOfYellowish','sumOfRustPatches','sumOfRotten','sumOf45');

	$defectQuantity = array();

	for($k=0;$k<count($defects);$k++){
		$defectQuantity[$k] =0;
		$finalValue[$k] = 0;
	}

	$c = 1;

	foreach ($res as $rr){
		$areaId = $rr['id'];
		$proType = $proObj->getProTypeById($areaId);

		if($proType == "1"){
			$vehicleNo = $rr['vehicleNo'];
			$date = $rr['date'];
				
			$connect->resetResult();
			$connect->select('qa_area','cate_id',"areaId='$areaId'");
			$resGrade = $connect->getResult();
			$grade = $resGrade[0]['cate_id'];

			$gradeId = $rr['gradeId'];
			$connect->resetResult();
			$connect->select('qa_grade','sampleWeight',"gradeId='$gradeId' AND cate_id='$grade'");
			$res1 = $connect->getResult();

			$sampleWeight = $res1[0]['sampleWeight'];
			$totalFruit = $sampleWeight * $rr['fruitCount'];

			if($c != 1){
				if($areaId == $oldId && $vehicleNo == $oldNo && $date == $oldDate ){
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
						
					$oldId = $rr['id'];
					$oldNo = $rr['vehicleNo'];
					$oldDate = $rr['date'];
					$currCount = 1;
					$arrCount++;
				}

			}else{
				$oldId = $rr['id'];
				$oldNo = $rr['vehicleNo'];
				$oldDate = $rr['date'];

				for($i=0;$i<count($defects);$i++){
					$defectQuantity[$i] = ($rr[$defects[$i]]/$totalFruit)*100;
				}
				$c++;

			}
		}
	}
		$lastValueSet = array();
			
		if(!empty($finalValue)){
			for($j=0;$j<count($defects);$j++){
				$lastValueSet[$j] = ($finalValue[$j] + $defectQuantity[$j]/$currCount)/($arrCount+1) ;
			}
		}else{
			for($i=0;$i<count($defects);$i++){
				$lastValueSet[$i] = $defectQuantity[$i]/$currCount;
			}	
		}
		
	print json_encode($lastValueSet);
}

if(isset($_POST['graph3Tot'])){

	$connect = new HDatabase();
	$connect->connect();
	$connect->select('qa_gradeStock','*',"date>='$startDate' AND date<='$endDate'","date,vehicleNo ASC");
	$res = $connect->getResult();
	
	$oldId = "";
	$oldNo = "";
	$oldDate = "";

	$currCount = 1;
	$finalValue=array();
	$arrCount = 0;

	$defects = array('sumOfSmallFruit','sumOfLargeFruit','sumOfFlyAttacked','sumOfPeeledOff',
	'sumOfBoreAttacked','sumOfSandEmbedded','sumOfShrivelled','sumOfDeformed','sumOfVirusAttacked',
	'sumOfMechanicalDamaged','sumOfYellowish','sumOfRustPatches','sumOfRotten','sumOf45');

	$defectQuantity = array();

	for($k=0;$k<count($defects);$k++){
		$defectQuantity[$k] =0;
		$finalValue[$k] = 0;
	}

	$c = 1;

	foreach ($res as $rr){
		$areaId = $rr['id'];
		$vehicleNo = $rr['vehicleNo'];
		$date = $rr['date'];

		$connect->resetResult();
		$connect->select('qa_area','cate_id',"areaId='$areaId'");
		$resGrade = $connect->getResult();
		$grade = $resGrade[0]['cate_id'];

		$gradeId = $rr['gradeId'];
		$connect->resetResult();
		$connect->select('qa_grade','sampleWeight',"gradeId='$gradeId' AND cate_id='$grade'");
		$res1 = $connect->getResult();

		$sampleWeight = $res1[0]['sampleWeight'];
		$totalFruit = $sampleWeight * $rr['fruitCount'];
			
		if($c != 1){
			if($areaId == $oldId && $vehicleNo == $oldNo && $date == $oldDate ){
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

				$oldId = $rr['id'];
				$oldNo = $rr['vehicleNo'];
				$oldDate = $rr['date'];
				$currCount = 1;
				$arrCount++;
			}
				
		}else{
			$oldId = $rr['id'];
			$oldNo = $rr['vehicleNo'];
			$oldDate = $rr['date'];

			for($i=0;$i<count($defects);$i++){
				$defectQuantity[$i] = ($rr[$defects[$i]]/$totalFruit)*100;
			}
			$c++;
				
		}
			
	}
	$lastValueSet = array();
		
	if(!empty($finalValue)){
		for($j=0;$j<count($defects);$j++){
			$lastValueSet[$j] = ($finalValue[$j] + $defectQuantity[$j]/$currCount)/($arrCount+1) ;
		}
	}else{
		for($i=0;$i<count($defects);$i++){
			$lastValueSet[$i] = $defectQuantity[$i]/$currCount;
		}	
	}	
		
	print json_encode($lastValueSet);
}

if(isset($_POST['graph2'])) {
	$project = new Project();
	$season = new Season();
	$ongoingSeason = $season->getOngoingSeasonId();
	$db = HDatabase::getInstance();

	$weeks = getWeeks();
	$firstWeek = getfirstWeek();
	$weekArray = sortWeeks($weeks);
	$weekValues = array();
	for($i=0;$i<count($weeks);$i++) {
		$weekValues[$i] = 0;
		$db->resetResult();
		$db->select("qa_arrivalData qa,qa_area q","qa.quantity","qa.weekNo='".$weekArray[$i]."' AND qa.projectId=q.areaId AND q.areaType='0' AND qa.seasonId='$ongoingSeason'");
		$result = $db->getResult();
		if($result){
			$j=0;
			foreach ($result as $temp){
				$weekValues[$i]+=$temp['quantity'];
				$j++;

			}
		}
	}
	$j_array=array();
	$j_array['weeks']=$weekArray;
	$j_array['pattern']=$weekValues;
	
	$stocks = array();
	for($i=0;$i<count($weekArray);$i++){
		$stocks[$i] = 0;
		$currentWeek=getSeperateWeek($weekArray[$i]);
		$weekStart = $currentWeek[0]." 00:00:00";
		$weekEnd = $currentWeek[1]." 23:59:59";
			
		$db->resetResult();
		$db->select("qa_stock qs,qa_area qa","qs.quantity","qs.id = qa.areaId AND qa.areaType='0' AND qs.date>='$weekStart' AND qs.date<='$weekEnd'");
		$res = $db->getResult();

		$db->resetResult();
		$db->select('qa_small_crop qs,qa_area qa','qs.total_DQ',"qs.id = qa.areaId AND qa.areaType='0' AND qs.date>='$weekStart' AND qs.date<='$weekEnd'");
		$resultSmall = $db->getResult();
		
		if($res) {
			foreach ($res as $stock) {
				$stocks[$i] += $stock['quantity'];
			}
		} 
		
		if($resultSmall) {
			foreach ($resultSmall as $stocksmall) {
				$stocks[$i] += $stocksmall['total_DQ'];
			}
		}
	}
	$roundedStocks = array();
	for($i=0;$i<count($stocks);$i++){
		$temp = $stocks[$i]/1000;
		$roundedStocks[$i]=round($temp,2);
	}
	$j_array['stocks']= $roundedStocks;
	header('Content-type:application/json');
	print json_encode($j_array);

}


function getfirstWeek(){

	$db=new HDatabase();
	$db->connect();
	$season=new Season();
	$ongoingSeason=$season->getOngoingSeasonId();
	$db->select("qa_arrivalData","DISTINCT cropFrom" ,"seasonId='$ongoingSeason'");
	$res=$db->getResult();
	$weeks=array();

	if($res){
		$i=0;
		foreach ($res as $temp){
			$weeks[$i]=$temp['cropFrom'];
			$i++;
		}
		sort($weeks);
		$l=array_shift($weeks);
		return $l;
	}else {
		return false;
	}
}

function getWeeks(){
	$db=new HDatabase();
	$db->connect();
	$db->resetResult();
	$season=new Season();
	$ongoingSeason = $season->getOngoingSeasonId();
	$db->select("qa_arrivalData","DISTINCT weekNo","seasonId='$ongoingSeason'");
	$res = $db->getResult();
	error_log('season => '.json_encode($res));
	
	$weeks = array();
	$ret = array();
	if($res){
		$i=0;
		foreach ($res as $temp){
			$weeks[$i]=$temp['weekNo'];
			$i++;
		}
	}
	return $weeks;
}

function sortWeeks($weeks){

	$weekArray=array();
	$sortedArray=array();
	for($i=0;$i<count($weeks);$i++){
		$week=getSeperateWeek($weeks[$i]);
		$weekArray[$i]['start']=$week[0];
		$weekArray[$i]['flag']=$i;

	}
	sort($weekArray);
	for($j=0;$j<count($weekArray);$j++){
		$sortedArray[$j]=$weeks[$weekArray[$j]['flag']];

	}
	return $sortedArray;
}


function getSeperateWeek($week){
	$sp1=explode("/", $week);
	$y=$sp1[2];
	$s1=explode("-",$sp1[0]);
	$fd=$s1[0];
	$fm=$s1[1];
	$s2=explode("-",$sp1[1]);
	$ld=$s2[0];
	$lm=$s2[1];
	$week_ret=array();
	$week_ret[0]=date($y."-".$fm."-".$fd);
	$week_ret[1]=date( $y."-".$lm."-".$ld);

	return $week_ret;
}
if(isset($_POST['graph2EX'])){
	error_log('here');
	$project = new Project();
	$season = new Season();
	$ongoingSeason = $season->getOngoingSeasonId();
	$db = new HDatabase();
	$db->connect();
	$weeks=getWeeks();
	$firstWeek = getfirstWeek();
	$weekArray = sortWeeks($weeks);
	$weekValues=array();
	for($i=0;$i<count($weeks);$i++){
		$weekValues[$i]=0;

		$db->resetResult();
		$db->select("qa_arrivalData qa,qa_area q","qa.quantity","qa.weekNo='".$weekArray[$i]."' AND qa.projectId=q.areaId AND q.areaType='1' AND qa.seasonId='$ongoingSeason'");
		$result=$db->getResult();


		if($result){
			$j=0;
			foreach ($result as $temp){
				$weekValues[$i]+=$temp['quantity'];
				$j++;

			}
		}
	}
	$j_array=array();
	$j_array['weeks']=$weekArray;
	$j_array['pattern']=$weekValues;


	$stocks=array();
	/* finding the actual quantity*/

	for($i=0;$i<count($weekArray);$i++){
		$stocks[$i]=0;
		$currentWeek=getSeperateWeek($weekArray[$i]);
		$weekStart=$currentWeek[0]." 00:00:00";
		$weekEnd=$currentWeek[1]." 23:59:59";

		$db->resetResult();
		$db->select("qa_stock qs,qa_area qa","qs.quantity","qs.id=qa.areaId AND qa.areaType='1' AND qs.date>='$weekStart' AND qs.date<='$weekEnd'");
		$res=$db->getResult();
		$db->resetResult();

		$db->select('qa_small_crop qs,qa_area qa','qs.total_DQ',"qs.id=qa.areaId AND qa.areaType='1' AND qs.date>='$weekStart' AND qs.date<='$weekEnd'");
		$resNew = $db->getResult();

		if($res){
			for ($k=0;$k<count($res);$k++){
				$stocks[$i]+= $res[$k]['quantity'];
			}

		}
		if($resNew){

			for ($l=0;$l<count($resNew);$l++){
					
				$stocks[$i]+= $resNew[$l]['total_DQ'];
					

			}
		}

	}
	$roundedStocks=array();
	for($i=0;$i<count($stocks);$i++){

		$temp=$stocks[$i]/1000;
		$roundedStocks[$i]=round($temp,2);

	}
	$j_array['stocks']=$roundedStocks;

	print json_encode($j_array);



}

if(isset($_POST['graph2Tot'])){

	$project=new Project();

	//$oldestWeeksData=getOldestWeek();
	//$startweek=$oldestWeeksData['leastweek'];
	//$numofweeks=$oldestWeeksData['numofweeks'];
	$season=new Season();
	$ongoingSeason=$season->getOngoingSeasonId();

	$db=new HDatabase();
	$db->connect();

	$weeks=getWeeks();
	$firstWeek=getfirstWeek();
	$weekArray=sortWeeks($weeks);
	$weekValues=array();
	for($i=0;$i<count($weeks);$i++){
		$weekValues[$i]=0;

		$db->resetResult();
		$db->select("qa_arrivalData","quantity","weekNo='".$weekArray[$i]."' AND seasonId='$ongoingSeason'");
		$result=$db->getResult();
		if($result){
			$j=0;
			foreach ($result as $temp){
				$weekValues[$i]+=$temp['quantity'];
				$j++;

			}
		}
	}
	$j_array=array();
	$j_array['weeks']=$weekArray;
	$j_array['pattern']=$weekValues;
	$stockValues=array();
	//for($i=0;$i<count($weeks)){}
	$stocks=array();
	/* finding the actual quantity*/

	for($i=0;$i<count($weekArray);$i++){
		$stocks[$i]=0;
		$currentWeek=getSeperateWeek($weekArray[$i]);
		$weekStart=$currentWeek[0]." 00:00:00";
		$weekEnd=$currentWeek[1]." 23:59:59";

		$db->resetResult();
		$db->select("qa_stock","quantity","date>='$weekStart' AND date<='$weekEnd'");
		$res=$db->getResult();
		$db->resetResult();

		$db->select('qa_small_crop','total_DQ',"date>='$weekStart' AND date<='$weekEnd'");
		$resNew = $db->getResult();

		if($res){

			for ($k=0;$k<count($res);$k++){
					
				$stocks[$i]+= $res[$k]['quantity'];
					

			}


		}
		if($resNew){

			for ($l=0;$l<count($resNew);$l++){
					
				$stocks[$i]+= $resNew[$l]['total_DQ'];
					

			}
		}



		/*
		 if($res){

			foreach ($res as $tmp){
			$stocks[$i]+=$tmp['quantity'];


			}

			}*/

	}
	$roundedStocks=array();
	for($i=0;$i<count($stocks);$i++){

		$temp=$stocks[$i]/1000;
		$roundedStocks[$i]=round($temp,2);

	}


	$j_array['stocks']= $roundedStocks;
	print json_encode($j_array);



}

?>

