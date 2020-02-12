<?php
require_once '../../includes/HDatabase.php';

if(isset($_POST['details']) && isset($_POST['butValue'])){
	$data = $_POST['details'];
	$oldUsername = $_POST['oldUsername'];

	if($_POST['butValue'] == "Update"){
		$userId = $data[0];
		$userType = $data[1];
		$password = $data[2];
		$fname = $data[3];
		$lname = $data[4];
		$area = $data[5];
		$position = $data[6];
		$mobile = $data[7];

		$conOld = new HDatabase();
		$conOld->connect();
		$conOld->select('qa_user','avatar',"userId='$oldUsername'");
		$resultOld = $conOld->getResult();
		$profPic = $resultOld[0]['avatar'];

		$con = new HDatabase();
		$con->connect();
		$con->update('qa_user',"userId='$userId',userType='$userType',password='$password',fname='$fname',lname='$lname',areaId='$area',position='$position',mobileNo='$mobile',avatar='$profPic'" ,"userId='$oldUsername'");

		if($userType == "StationUser"){

			$getName = new HDatabase();
			$getName->connect();
			$getName->select('qa_station','inchargePersonId',"inchargePersonId='$oldUsername'");
			$getRes = $getName->getResult();

			if($getRes){
				$stationId = $getRes[0]['stationId'];
				$conn = new HDatabase();
				$conn->connect();
				$conn->update('qa_station',"stationId='$stationId',stationName='$area',inchargePersonId='$userId'","inchargePersonId='$oldUsername'");
			}else{
					
				$stationUserDetails =array();
					
				$stations=array('Alawwa','HJS',"Padiyathalawa");

				if($area == $stations[0]){
					$stationUserDetails[0] = 1;
					$stationUserDetails[1] = $area;
					$stationUserDetails[2] = $userId;
				}else if($area == $stations[1]){
					$stationUserDetails[0] = 2;
					$stationUserDetails[1] = $area;
					$stationUserDetails[2] = $userId;
				}
				else if($area == $stations[2]){
					$stationUserDetails[0] = 3;
					$stationUserDetails[1] = $area;
					$stationUserDetails[2] = $userId;
				}

				$conn = new HDatabase();
				$conn->connect();
				$conn->insert('qa_station', $stationUserDetails);
					
			}
		}

	}else{
		$con = new HDatabase();
		$con->connect();
		$con->insert('qa_user', $data);

		$userId = $data[0];
		$userType = $data[1];
		$area = $data[5];

		if($userType == "StationUser"){

			$stationUserDetails =array();

			$stations = array('Alawwa','HJS',"Padiyathalawa");

			if($area == $stations[0]){
				$stationUserDetails[0] = 1;
				$stationUserDetails[1] = $area;
				$stationUserDetails[2] = $userId;
			}else if($area == $stations[1]){
				$stationUserDetails[0] = 2;
				$stationUserDetails[1] = $area;
				$stationUserDetails[2] = $userId;
			}
			else if($area == $stations[2]){
				$stationUserDetails[0] = 3;
				$stationUserDetails[1] = $area;
				$stationUserDetails[2] = $userId;
			}

			$conn = new HDatabase();
			$conn->connect();
			$conn->insert('qa_station', $stationUserDetails);

		}
	}
}
if(isset($_POST['viewData'])){

	$conn = new HDatabase();
	$conn->connect();
	$conn->select('qa_user','*');
	$result = $conn->getResult();
	
	$users = "";
	
	echo '<h3>Existing Users</h3>';
	$users .= "<ul id='list-users'>";
	foreach ($result as $r){
		
		if($r['userType'] != "SuperAdministrator"){

		$users .=  '<li class="liFormat" ><div class="profilePic">';
		$users .= '<img src="files/users/avatars/'.$r['avatar'].'" height="75px" width="77px" /></div>';
		$users .= '<div class="details" ><h5>'.$r['fname']." ".$r['lname'].'</h5><p >'.$r['userType'].'<br/>'.$r['areaId'].'</p>';
		$users .= '<button id="butEdit" class="ui-state-default  user" onclick="editUser(\''.$r['userId'].'\')" >';
		$users .= 'edit</button>';
		$users .= '<button id="butDel" class="ui-state-default  user" onclick="delUser(\''.$r['userId'].'\')" >delete</button></div> </li>'; 
		}		
			
	}
	$users .= "</ul>";
	print $users;
}

if(isset($_POST['userId'])){
	$userId = $_POST['userId'];
	$con = new HDatabase();
	$con->connect();
	$con->select('qa_user','*',"userId='$userId'");
	header('Content-type:application/json');
	$result = $con->getResult();

	print json_encode($result[0]);

}
if(isset($_POST['uId'])){
	$uId = $_POST['uId'];
	$con = new HDatabase();
	$con->connect();
	$con->delete('qa_user',"userId='$uId'");
	$con->delete('qa_station',"inchargePersonId='$uId'");
	echo "User deleted successfully";
}
if(isset($_POST['uName'])){
	$uId = $_POST['uName'];
	$con = new HDatabase();
	$con->connect();
	$con->select('qa_user','*', "userId='$uId'");
	$res= $con->getResult();
	if($res){

		echo "* Name Exixts";
	}

}


?>