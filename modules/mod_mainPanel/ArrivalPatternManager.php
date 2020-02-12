<?php
require_once '../../includes/HDatabase.php';

if(isset($_POST['supplierArrival'])){
	$projectArrival = $_POST['supplierArrival'];
	
	$con = new HDatabase();
	$con->connect();
	$con->select('qa_area','areaName',"areaName LIKE '$projectArrival%'");
	$result = $con->getResult();
	
	if($result){
		foreach ($result as $r){
			echo '<li class="projectNameList" id="'.$r['areaName'].'" onclick="setProjectName(this.id)">'.$r['areaName'].'</li>';
		}
	}else{
		echo '<li class="projectNameList">No Projects</li>';
	}	
}
if(isset($_POST['supplierArrivalEdit'])){
	$projectArrival = $_POST['supplierArrivalEdit'];
	
	$con = new HDatabase();
	$con->connect();
	$con->select('qa_area','areaName',"areaName LIKE '$projectArrival%'");
	$result = $con->getResult();
	
	if($result){
		foreach ($result as $r){
			echo '<li class="projectNameListEdit" id="'.$r['areaName'].'" onclick="setProjectNameEdit(this.id)">'.$r['areaName'].'</li>';
		}
	}else{
		echo '<li class="projectNameListEdit">No Projects</li>';
	}	
}

if(isset($_POST['projectName'])){
	$projectName = $_POST['projectName'];
	
	$db = new HDatabase();
	$db->connect();
	$db->select('qa_area','gradeCategory',"areaName='$projectName'");
	$res = $db->getResult();
	$gradeCat = $res[0]['gradeCategory'];
	
	$resGrade = new HDatabase();
	$resGrade ->connect();
	$resGrade->select('qa_grade','*',"gradeCategory ='$gradeCat'","gradeId ASC");
	$resultGrade = $resGrade->getResult();

	$resultSet = "";
	
	foreach ($resultGrade as $rr){
		$resultSet .='<option value="'.$rr['fruitCount'].'">'.$rr['fruitCount'].'</option>';
	}
	echo $resultSet;
	
}

if(isset($_POST['arrivalArray'])){
	$arrivalArray = $_POST['arrivalArray'];
	$dataArray = $_POST['dataArray'];
	
	$con = new HDatabase();
	$con->connect();
	$con->select('qa_area','gradeCategory',"areaName = '$arrivalArray[1]'");
	$res = $con->getResult();
	$gradeCat = $res[0]['gradeCategory'];
	
	$conn = new HDatabase();
	$conn->connect();
	$conn->select('qa_grade','gradeId',"gradeCategory ='$gradeCat' AND fruitCount='$arrivalArray[2]'");
	$ress = $conn->getResult();
	$gradeId = $ress[0]['gradeId'];
	$arrivalArray[2] = $gradeId;
	
	 $db = new HDatabase();
	 $db->connect();
	 $db->select('qa_arrivalData','*',"project='$arrivalArray[1]' AND gradeId='$gradeId' AND seasonId='$arrivalArray[3]'");
	 $r = $db->getResult();
	
	 if(!$r){
		for($i=0; $i<count($dataArray); $i++){
			
			$arrivalArray[4] = $dataArray[$i][0];
			$arrivalArray[5] = $dataArray[$i][1];
			$arrivalArray[6] = $dataArray[$i][2];
			$arrivalArray[0] = $dataArray[$i][3];
		
			$db1 = new HDatabase();
			$db1->connect();
			$db1->insert('qa_arrivalData', $arrivalArray);		
		}
		echo "Data Submitted Successfully";
		
	 }else{
	 	echo "Arrival Pattern exists";
	 }	
}

if(isset($_POST['projectNameEdit'])){
	$projectNameEdit = $_POST['projectNameEdit'];
	$subGradeEdit = $_POST['subGradeEdit'];
	$seasonEdit = $_POST['seasonEdit'];
	
	$getGradeCat = new HDatabase();
	$getGradeCat->connect();
	$getGradeCat->select('qa_area','gradeCategory',"areaName='$projectNameEdit'");
	$resGradeCat = $getGradeCat->getResult();
	$gradeCat = $resGradeCat[0]['gradeCategory'];
	
	$getGrade = new HDatabase();
	$getGrade->connect();
	$getGrade->select('qa_grade','gradeId',"gradeCategory='$gradeCat' AND fruitCount='$subGradeEdit'");
	$resGrade = $getGrade->getResult();
	$gradeId = $resGrade[0]['gradeId'];
		
	$dbEdit = new HDatabase();
	$dbEdit->connect();
	$dbEdit->select('qa_arrivalData','weekNo,cropFrom,cropTo,quantity',"project='$projectNameEdit' AND gradeId='$gradeId' AND seasonId='$seasonEdit'","weekNo ASC");
	$resData = $dbEdit->getResult();
		
	$editData = "";
	$weekCount = 0;
	
	$tableHeader = '<tr style="background-color: none;text-align: center; font-weight: bold;" >'
			.'<th>Week</th>'
			. '<th>From</th>'
			. '<th>To</th>'
			. '<th>Quantity</th>'
			. '</tr>' ;
	
	$editData .= $tableHeader;	
	if($resData){		
	foreach ($resData as $rData){
		$weekNo = $rData['weekNo'];
		$cropFrom =  $rData['cropFrom'];
		$cropTo = $rData['cropTo'];
		$quantity = $rData['quantity'];
		
		$weekCount++;
		
		$weekValue = "<tr style='background-color:#ccc;text-align:center;' ><td id='weekEdit-".$weekCount."'>".$weekNo."</td>".
				"<td ><input type='text' value='".$cropFrom ."' id='fromEdit-".$weekCount."' onclick=setWeekCount('".$weekCount."') /></td><td ><input type='text' value='".$cropTo."' id='toEdit-".$weekCount."'</td>".
				"<td width='200'><input id='quantityEdit-".$weekCount."' value='" .$quantity. "' /></td>".
				"</tr>";
		
		$editData .= $weekValue;
	}
	
	echo $editData;
	}else{
		echo "No Arrival Pattern found";
	}
}

if(isset($_POST['projectEditSave'])){
	$projectSave = $_POST['projectEditSave'];
	$subGradeSave = $_POST['subGradeEditSave'];
	$seasonSave = $_POST['seasonEditSave'];
	$firstTableData = $_POST['firstTableData'];	
	
	$getGradeCat = new HDatabase();
	$getGradeCat->connect();
	$getGradeCat->select('qa_area','gradeCategory',"areaName='$projectSave'");
	$resGradeCat = $getGradeCat->getResult();
	$gradeCat = $resGradeCat[0]['gradeCategory'];
	
	$getGrade = new HDatabase();
	$getGrade->connect();
	$getGrade->select('qa_grade','gradeId',"gradeCategory='$gradeCat' AND fruitCount='$subGradeSave'");
	$resGrade = $getGrade->getResult();
	$gradeId = $resGrade[0]['gradeId'];
	
	$save = new HDatabase();
	$save->connect();
	
	for($j=1;$j<count($firstTableData);$j++){
		$dataArray = $firstTableData[$j];
		$save->update('qa_arrivalData',"weekNo='$dataArray[3]',project='$projectSave',gradeId='$gradeId',seasonId='$seasonSave',cropFrom='$dataArray[0]',cropTo='$dataArray[1]',quantity='$dataArray[2]'", "weekNo='$dataArray[3]' AND project='$projectSave' AND gradeId='$gradeId' AND seasonId='$seasonSave'");
	}
	
	
	if(isset($_POST['secondTableData'])){
		$secondTableData = $_POST['secondTableData'];
				
		$saveAdd = new HDatabase();
		$saveAdd->connect();
		
		for($k=0;$k<count($secondTableData);$k++){
			$insertDataArray = array();
			$dataArraySecond = $secondTableData[$k];
				
			$insertDataArray[0] = $dataArraySecond[3];
			$insertDataArray[1] = $projectSave;
			$insertDataArray[2] = $gradeId;
			$insertDataArray[3] = $seasonSave;
			$insertDataArray[4] = $dataArraySecond[0];
			$insertDataArray[5] = $dataArraySecond[1];
			$insertDataArray[6] = $dataArraySecond[2];
			
			if($insertDataArray[6] != ""){
				$saveAdd->insert('qa_arrivalData', $insertDataArray);
			}
		}	
	}
	echo "Data Updated Successfully.";
}



?>