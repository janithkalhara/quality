<?php

session_start();
date_default_timezone_set('Asia/Kolkata');

require_once '../includes/HDatabase.php';
//Unset the variables stored in session
$uid=$_SESSION['SESS_MEMBER_ID'];
unset($_SESSION['SESS_MEMBER_ID']);
unset($_SESSION['SESS_FIRST_NAME']);
unset($_SESSION['SESS_LAST_NAME']);
unset($_SESSION['SESS_USERTYPE'] );
unset($_SESSION['SESS_USERAVATAR']);
setUserLoggedOut($uid);

header("location:../index.php");
function setUserLoggedOut($id){
	$db=new HDatabase();
	$db->connect();
	$out=date('Y-m-d h:i:s');
	$db->update("qa_loggedUsers","flag='0',intime='0000-00-00 00:00:00',outtime='$out'","userId='$id'");
	
}
?>