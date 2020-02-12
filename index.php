<?php
session_start();
if(isset($_SESSION['SESS_MEMBER_ID'])) { 
	$redirect_to = isset($_GET['redirect-to']) ? $_GET['redirect-to'] : '/home.php';  
	header('Location:'.$redirect_to);exit();
}
include_once 'config.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo APP_NAME; ?></title>
<link rel="stylesheet" type="text/css" href="css/index.css" />
<script type="text/javascript" src="libraries/jqueryCustomUI/js//jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="libraries/jqueryCustomUI/js/jquery-ui.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#login-div').draggable();
	$('#userid').focus();
});</script>
</head>
<body>
	<div id="login-div">
		<form action="login/loginExec.php" method="post" id="" class="h-class-loginform" onsubmit="return ">
			<h3 align="center">Quality Analysis System</h3>
			<p  align="center">HJS Condiments LTD | Sunfrost (PVT) LTD</p>
			<hr>
			<table border="0" cellpadding="0" cellspacing="0" align="center">
				<tbody>
					<tr>
						<td>username</td>
						<td><input type="text" class="username" id="userid" name="userid" value="">
						</td>
						<td></td>
					</tr>
					<tr>
						<td>password</td>
						<td><input type="password" class="password" id="login-password" name="password" value="">
						</td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td>
						<input type="submit" class="submit" id="" name="submit" value="Login">
						<input type="hidden" name="redirect-to" value="<?php echo isset($_GET['redirect-to']) ? $_GET['redirect-to'] : null; ?>">
						</td>
						<td></td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
</body>
</html>