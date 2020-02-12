<?php

require_once '../../includes/HDatabase.php';
	require_once ("resize-class.php");
if(isset($_POST['flag']) && $_POST['flag']=="useredit"){
	$userId = $_POST['userId'];
	
	$conn = new HDatabase();
	$conn->connect();
	$conn->select('qa_user','*',"userId='$userId'");
	$result = $conn->getResult();
	
	$user=array($result[0]['fname'],
				$result[0]['lname'],
				$result[0]['userId'],
				$result[0]['password'],
				$result[0]['userType'],
				$result[0]['areaId'],
				$result[0]['position'],
				$result[0]['mobileNo'],
				$result[0]['avatar']
				);
	header("Content-type:application/json");
	print json_encode($user);
	//echo $result[0]['fname']."-".$result[0]['lname']."-".$result[0]['userId']."-".$result[0]['password']."-".$result[0]['userType']
	//."-".$result[0]['areaId']."-".$result[0]['position']."-".$result[0]['mobileNo']."-".$result[0]['avatar'];
}

else{

$oldUserId = $_POST['oldUserId'];	
$fname = $_POST['fNameEdit'];
$lname = $_POST['lNameEdit'];
$email = $_POST['emailEdit'];
$password = md5($_POST['pwordEdit']);
$userType = $_POST['userTypeEdit'];
$area = $_POST['areaEdit'];
$position = $_POST['positionEdit'];
$mobile = $_POST['mobileEdit'];
$profPic ;

if ($_FILES["file"]["error"] > 0)
    {
$conOld = new HDatabase();
$conOld->connect();    	
$conOld->select('qa_user','avatar',"userId='$oldUserId'");
$resultOld = $conOld->getResult();
$profPicOld = $resultOld[0]['avatar'];   

$getExt = explode(".", $profPicOld);
$ext;

	foreach ($getExt as $n){
      		$ext = $n;
       	} 

rename($_SERVER["DOCUMENT_ROOT"]."/files/users/avatars/" .$profPicOld, $_SERVER["DOCUMENT_ROOT"]."/files/users/avatars/" .$email.".".$ext);
$profPic;
$profPic = $email.".".$ext;   
   	
   
$con = new HDatabase();
$con->connect();
$con->update('qa_user',"userId='$email',userType='$userType',password='$password',fname='$fname',lname='$lname',areaId='$area',position='$position',mobileNo='$mobile',avatar='$profPic'" ,"userId='$oldUserId'");

$sid = $_GET['sid'];
//session_id($sid);
//session_start();
//session_regenerate_id();
//$sid = session_id();
//session_write_close();
//session_id($sid);
//session_start();

      header('location:../../home.php');
    }
  else
    { $names =explode('.',$_FILES['file']['name']);
      	
      	$imageExt = '';
      	foreach ($names as $n){
      		$imageExt = $n;
       	}      	
      move_uploaded_file($_FILES["file"]["tmp_name"],$_SERVER["DOCUMENT_ROOT"]."/files/users/avatars/" .$email.".".$imageExt);
      $profPic=$email.".".$imageExt;
      /**
       * resizing image
       */
    $resizeObj = new resize($_SERVER["DOCUMENT_ROOT"]."/files/users/avatars/" .$profPic);

	// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
	$resizeObj -> resizeImage(200, 200, 'crop');

	// *** 3) Save image
	$resizeObj -> saveImage($_SERVER["DOCUMENT_ROOT"]."/files/users/avatars/" .$profPic, 100);
      //echo "Stored in: " . "upload/" . $email.".jpg";
     // chmod('upload/'.$_FILES["file"]["name"],0755);
    $con = new HDatabase();
$con->connect();
$con->update('qa_user',"userId='$email',userType='$userType',password='$password',fname='$fname',lname='$lname',areaId='$area',position='$position',mobileNo='$mobile',avatar='$profPic'" ,"userId='$oldUserId'");
      
 
$sid = $_GET['sid'];
/* session_id($sid);
session_start();
session_regenerate_id();
$sid = session_id();
session_write_close();
session_id($sid);
session_start();
 */
      header('location:../../home.php');
         
    }
  

}

?>