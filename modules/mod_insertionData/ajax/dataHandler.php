<?php
session_start();
require_once '../../../includes/HDatabase.php';
require_once '../../../roles/user.php';
require_once '../../../libraries/base/project/lib_project.php';
require_once '../../../includes/Logger.php';
require_once '../../../libraries/base/season/lib_season.php';


$handler=new dataHandler();
if(isset($_POST['flag'])){
	$flag=$_POST['flag'];
	
	if($flag=='save'){
	
		$handler->saveHeader($_POST['saveheader']);
		
		$gs=$_POST['saveGradeStock'];
		
		for($i=0;$i<count($gs);$i++){
			if(is_array($gs[$i]) && !empty($gs[$i])){
				$handler->saveGradeStock($gs[$i]);
			}
		}
		$cs=$_POST['savesamples'];
		for($j=0;$j<count($cs);$j++){
			for ($k=0;$k<count($cs[$j]);$k++){
				if($cs[$j][$k]!=0){
						$handler->saveSampleDetails($cs[$j][$k]);
				}
			
			}
		}
		$handler->saveUserDetails($_POST['saveuserDetails']);
		$savecenterdata=$_POST['saveCenterData'];
		for($i=0;$i<6;$i++){
			
			if(isset($savecenterdata[$i])){
				$handler->saveCenterData($savecenterdata[$i]);
			}
			
		}
		
		$handler->saveCenterQuantity($_POST['saveCenterQuantity']);
		$handler->saveImageData($_POST['saveImageDetails']);
	}
}


class dataHandler{
	private  $stockerror;
	
	function dataHandler(){
		$this->stockerror=false;
	}
	
	function saveHeader($post){
		$db=new HDatabase();
		$db->connect();
		/* Setting Data */

		$project=$post['areaId'];
		$projectName=$post['areaName'];
		$quantity=$post['quantity'];
		$vehicleNo=$post['vehicleNo'];
		$handovering=$post['handovering'];
		$lorryCovering=$post['lorryCovering'];
		$badSmell=$post['badSmell'];
		$otherGoods=$post['otherGoods'];
		$labelling=$post['labelling'];
		$qualityReports=$post['qualityReports'];
		$date=$post['date'];

		/*
		 * insertion array for stock table
		 */
		$insert=array($project,$quantity,$vehicleNo,
		$handovering,$lorryCovering,$badSmell,$otherGoods,
		$labelling,$qualityReports,$date);
		//setting rows
		
		$rows="id,quantity,vehicleNo,handovering,lorryCovering,badSmell,";
		$rows.="otherGoods,labelling,qualityReports,date";

		if($db->insert('qa_stock', $insert,$rows)){

		}

		else{
			//error occured
			error_log($db->getError());
			$this->setError();
		}


	}
	
	function saveGradeStock($post){
		$db=new HDatabase();
		$db->connect();
		
		$id=$post['projectId'];
		$project=$post['project'];
		$vehicleNo=$post['vehicleNo'];
		$date=$post['date'];
		$gradeId=$post['gradeId'];
		$noOfCrates=$post['noOfCrates'];
		$notedWeight=$post['notedWeight'];
		$trueWeight=$post['trueWeight'];
		$averageFruitCount=$post['averageFruitCount'];
		$fruitCount=$post['fruitCount'];
		$sumOfSmallFruit=$post['sumOfSmallFruit'];
		$sumOfLargeFruit=$post['sumOfLargeFruit'];
		$sumOfFlyAttacked=$post['sumOfFlyAttacked'];
		$sumOfPeeledOff=$post['sumOfPeeledOff'];
		$sumOfBoreAttacked=$post['sumOfBoreAttacked'];
		$sumOfSandEmbedded=$post['sumOfSandEmbedded'];
		$sumOfShrivelled=$post['sumOfShrivelled'];
		$sumOfDeformed=$post['sumOfDeformed'];
		$sumOfVirusAttacked=$post['sumOfVirusAttacked'];
		$sumOfMechanicalDamaged=$post['sumOfMechanicalDamaged'];
		$sumOfYellowish=$post['sumOfYellowish'];
		$sumOfRustPatches=$post['sumOfRustPatches'];
		$sumOf45=$post['sumOf45'];
		$sumOfRotten=$post['sumOfRotten'];
		$totalPerOfDefectGrade=$post['totalPerOfDefectGrade'];
		$totalPerOfDefect=$post['totalPerOfDefect'];
		$reducedPerOfDefectGrade=$post['reducedPerOfDefectGrade'];
		$reducedPerOfDefect=$post['reducedPerOfDefect'];
		$payableQuantity=$post['payableQuantity'];

		$drqNoOfBags=$post['drqNoOfBags'];
		$drqNoOfKilos=$post['drqNoOfKilos'];
		/*
		 * insertion array for gradeStock table
		 */
		$insertArray=array($id,$project,$vehicleNo,$date,$gradeId,$noOfCrates,$notedWeight,
		$trueWeight,$averageFruitCount,$fruitCount,$sumOfSmallFruit,$sumOfLargeFruit,$sumOfFlyAttacked,
		$sumOfPeeledOff,$sumOfBoreAttacked,$sumOfSandEmbedded,$sumOfShrivelled
		,$sumOfDeformed,$sumOfVirusAttacked,$sumOfMechanicalDamaged,
		$sumOfYellowish,$sumOfRustPatches,$sumOf45,$sumOfRotten,$totalPerOfDefectGrade,$totalPerOfDefect,
		$reducedPerOfDefectGrade,$reducedPerOfDefect,$payableQuantity,$drqNoOfBags,$drqNoOfKilos);

		/*
		 * setting rows
		 */
		$rows="id,project,vehicleNo,date,gradeId,noOfCrates,notedWeight,trueWeight,";
		$rows.="averageFruitCount,fruitCount,sumOfSmallFruit,sumOfLargeFruit,sumOfFlyAttacked,";
		$rows.="sumOfPeeledOff,sumOfBoreAttacked,sumOfSandEmbedded,sumOfShrivelled,sumOfDeformed,";
		$rows.="sumOfVirusAttacked,sumOfMechanicalDamaged,sumOfYellowish,sumOfRustPatches,sumOf45,";
		$rows.="sumOfRotten,totalPerOfDefectGrade,totalPerOfDefect,reducedPerOfDefectGrade,reducedPerOfDefect,";
		$rows.="payableQuantity,drqNoOfBags,drqNoOfKilos";
		
		/*
		 * inserting data
		 */
		if($db->insert('qa_gradeStock',$insertArray ,$rows)){

		}else{			
			error_log(__FUNCTION__);
			$this->setError();
		}
	}

	function  saveSampleDetails($post){
			
		$sampleId=$post['sampleId'];
		$projectId=$post['projectId'];
		$project=$post['project'];
		$vehicleNo=$post['vehicleNo'];
		$gradeId=$post['gradeId'];
		$centerId=$post['centerId'];
		$date=$post['date'];
		$sampleFruitCount=$post['sampleFruitCount'];
		$smallFruit=$post['smallFruit'];
		$largeFruit=$post['largeFruit'];
		$flyAttacked=$post['flyAttacked'];
		$peeledOff=$post['peeledOff'];
		$boreAttacked=$post['boreAttacked'];
		$sandEmbedded=$post['sandEmbedded'];
		$shrivelled=$post['shrivelled'];
		$deformed=$post['deformed'];
		$virusAttacked=$post['virusAttacked'];
		$mechanicalDamaged=$post['mechanicalDamaged'];
		$yellowish=$post['yellowish'];
		$rustPatches=$post['rustPatches'];
		$fruits45=$post['45'];
		$accepted=$post['accepted'];
		$spoiled=$post['spoiled'];
			
		$db=new HDatabase();
		$db->connect();
		/*
		 * insert array sample table
		 */
		$insertArray=array($projectId,$project,$sampleId,$vehicleNo,$gradeId,$centerId,$date,$sampleFruitCount,$smallFruit,$largeFruit,
		$flyAttacked,$peeledOff,$boreAttacked,$sandEmbedded,$shrivelled,$deformed,$virusAttacked,
		$mechanicalDamaged,$yellowish,$rustPatches,$fruits45,$accepted,$spoiled);

		/*
		 * setting rows
		 */
		$rows="id,project,sampleId,vehicleNo,gradeId,centerId,date,fruitCount,smallFruit,";
		$rows.="largeFruit,flyAttacked,peeledOff,boreAttacked,sandEmbedded,shrivelled,deformed,";
		$rows.="virusAttacked,mechanicalDamaged,yellowish,rustPatches,fruits45,accepted,spoiled";

		if( $db->insert('qa_sample',$insertArray ,$rows)){
			
		}else {
			//error occured
			error_log(__FUNCTION__);
				$this->setError();
		}

			
	}

	function saveUserDetails($post){
		$db=new HDatabase();
		$db->connect();
		$pid=$post['projectId'];
		$project=$post["project"];
		$vehicleNo=$post["vehicleNo"];
		$userId=$_SESSION['SESS_MEMBER_ID'];
		$db->select('qa_station','stationId',"inchargePersonId='$userId'");
		$res=$db->getResult();
		$stationId=$res[0]['stationId'];
		$date=$post['date'];
		
		$insert=array($vehicleNo,$userId,$stationId,$date,$pid);

		$rows="vehicleNo,userId,stationId,date,areaId";

		if($db->insert('qa_stockUpdates', $insert)){

		}else{
			//error occured
			error_log(__FUNCTION__);
			$this->setError();
		}

			
	}
	
	function saveCenterData($post){
		$db=new HDatabase();
		$db->connect();

		$project=$post['project'];
		$projectId=$post['projectId'];
		$date=$post['date'];
		$vehicleNo=$post['vehicleNo'];
		$centerFakeNo=$post['centerFakeNo'];
		$centerName=$post['centerName'];
		$tmNo=$post['tmNo'];
		//getting the season
		$season=new Season();
		$s=$season->getRelaventSeasonByDate($date);
		$insertArray=array($projectId,$s,$project,$date,$vehicleNo,$centerFakeNo,$centerName,$tmNo);
		$rows="id,seasonId,project,date,vehicleNo,centerFakeId,centerName,TMno";
		if($db->insert('qa_center_fakes',$insertArray)){

		}
		else{
			$this->setError();
		}

	}

	function prepareCenterQtyData($set)
    {
        $prepped = [];
        foreach ($set as $i => $data) {
            if($i > 5 ) {
                $data = floatval($data);
            }
            $prepped[] = $data;
        }
        error_log(__METHOD__ . ' ' . json_encode($prepped));
        return $prepped;
    }

	function saveCenterQuantity($post){

		$dataArray = $post;
		$db = new HDatabase();
		$error=false;
		for($i=0;$i<count($dataArray);$i++){
			$db->resetResult();
			$db->connect();
			$dataSet = $this->prepareCenterQtyData($dataArray[$i]);
			if($db->insert('qa_centerQuantity', $dataSet)){
				
			}else{
				$error=true;
			}
		}
		if($error){
				$this->setError();
		}else{
			
		}
	}

	function saveImageData($post){
		$db=new HDatabase();
		$db->connect();
			
		$log=new Logger("../../../logfile.log");
		$project=$post['project'];
		$projectId=$post['projectId'];
		$date=$post['date'];
		$vehicleNo=$post['vehicleNo'];
		$image1=$post['image1'];
		$image2=$post['image2'];
		$image3=$post['image3'];
		$image_desc1=$post['image_desc1'];
		$image_desc2=$post['image_desc2'];
		$image_desc3=$post['image_desc3'];
		$user=$_SESSION['SESS_MEMBER_ID'];

		$insertArray=array($projectId,$project,$date,$vehicleNo,$image1,
		$image2,$image3,$image_desc1,$image_desc2,$image_desc3);

		$rows="id,project,date,vehicleNo,image1,image2,image3,image_desc1,image_desc2,image_desc3";
		if($db->insert('qa_stockImages', $insertArray,$rows)){

		}
		else{
			$this->setError();
		}
		
		if($this->getErrorState() === true){
			//print "There were Some problems occured .Please Check your insertion and submit it again!.";
			if($this->getConfirmedStock($projectId, $vehicleNo, $date)){
				print "You have submitted existing stock data.\nPlease try with diffrent stock data.";
			}else{
				print 'There were some errors occured.Please Check Your Insertion Data!';
				$this->deleteStock($projectId, $vehicleNo, $date);
			}
			
			$logString="User ' ".$user." ' tried to add data(Large/Medium grade). in project :'".$project."' with Vehicle number :'".$vehicleNo."' for date :'".$date."' . But not succeeded";
			$log->log(date('Y-m-d h:i:s'),$logString);
			
			//error occured .Partially submitted data should be deleted
		
		}
		else{

			print "Stock Data Submitted Successfully!";
			$logString="User :' ".$user." ' added data(Large/Medium grade). in project :' ".$project." ' with Vehicle number :' ".$vehicleNo." ' for date :' ".$date." ' . Succeeded";
			/*
			 * logging the result
			 */
			$log->log(date('Y-m-d h:i:s'),$logString);
			$db->resetResult();
			$db->insert("qa_confirmed_stocks", array($projectId,$vehicleNo,$date));	

		}
	}


	function deleteStock($p,$v,$d){
		
		$db=new HDatabase();
		$db->connect();
		/*
		 * deleting stock table
		 */
		$db->delete("qa_stock","id='$p' AND vehicleNo='$v' AND date='$d'");
		
		/*
		 * deleting gradeStock table
		 */
		$db->delete("qa_gradeStock","id='$p' AND vehicleNo='$v' AND date='$d'");
		/*
		 * deleting sample table
		 */
		$db->delete("qa_sample","id='$p' AND vehicleNo='$v' AND date='$d'");
		
		/*
		 * deleting centerQuantity table
		 */
		$db->delete("qa_centerQuantity","id='$p' AND vehicleNo='$v' AND date='$d'");
		
		/*
		 * deleting center_fakes table
		 */
		$db->delete("qa_center_fakes","id='$p' AND vehicleNo='$v' AND date='$d'");
		/*
		 * deleting stockImages table
		 */
		$db->delete("qa_stockImages","id='$p' AND vehicleNo='$v' AND date='$d'");
		
		/*
		 * deleting stockUpdates table
		 */
		$db->delete("qa_stockUpdates","areaId='$p' AND userId='".$_SESSION['SESS_MEMBER_ID']."' AND vehicleNo='$v' AND date='$d'");
	}
	
	function setError(){
		$this->stockerror=true;
		
		
	}
	
	function getErrorState(){
		return $this->stockerror;
		
	}
	
	function getConfirmedStock($p,$v,$d){
		
		$db=new HDatabase();
		$db->connect();
		$db->select("qa_confirmed_stocks","*","id='$p' AND vehicleNo='$v' AND date='$d'");
		
		$res=$db->getResult();
		
		if($res){
			return true;
		}else {
			return false;
		}
		
		
	}
}
?>