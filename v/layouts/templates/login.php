<?php

class Login extends  Template{
	function render(){ ?>
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
	<html>
  		<head>
    	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
   	 	<meta name="viewport" content="width-device-width,initial-scale=1.0">
    	<title><?php print APP_NAME ?></title>
	    <?
		Html::importCss("bootstrap");
		Html::importCss("base");
	    Html::importJs("jquery-1.8.2.min");
	    Html::importJs("jquery-ui-1.9.1");
	    Html::importJs("bootstrap");
	    Html::importJs("base");
	    Html::importJs("login");
	    Html::importCss("login/login");
	     ?>
       	<script type="text/javascript">
                    var appServer={"name":"<?php echo APP_BASE_PATH; ?>",
					"appName":'<?php print APP_NAME; ?>'                    };
					$(document).ready(function(){
						$('#waiting').ajaxStart(function(){
							$(this).show();
								}).ajaxStop(function(){
									$(this).hide();
										});
						});
        </script>
	   	</head>
	    <body>
	    	<div class="container">
				<div id="alert-div"></div>
      			<form class="form-signin"  >
        			<img src"public/images/logo.png"/>
        				<h5 align="center">Information Management System</h5>
        					<input type="text" class="input-block-level" placeholder="Username" id="inputEmail">
        					<span class="help-inline" id="input-email-alert"></span>
        					<input type="password" class="input-block-level" placeholder="Password" id="inputPassword" >
        					<span class="help-inline" id="input-password-alert" ></span>
        					<label class="checkbox">
          						<input type="checkbox" value="remember-me"> Remember me
        					</label>
        					<button class="btn btn-medium btn-primary" type="button" id="submit-button">Sign in</button>
        					<a type="button" href="#Signup" data-toggle="modal">New user?</a>
      			</form>
		   </div>
 	<?php   
  	Html::importJs("signup/signup");

	$form = Factory::getFormInstance("Signup", "?url=sign/sign/register");
	$form->setAjax(true);
	$form->setFade(true);
	$form->setName("Signup");
	$form->setLayout(LAYOUT_COLUMN_ONE);
	
	$data = array(
		
		array("Username: ","input/text-username",""),
		array("Password :","input/password-signup_pass"),
		array("Verify Password :","input/password-signup_verify_pass"),
		array("E-mail: ","input/text-signup_email","adsad@gmail.com"),
		array("First Name :","input/text-signup_fname"),
		array("Last Name :","input/text-signup_lname"),
		array("Mobile :","input/text-signup_mobile"),
		array("Address :","input/text-address"),
		);

	$required = array(
		array("signup_email","please fill in the user name EX.abc@xyz.com"),
		array("username","Username is required "),
		array("signup_pass","please fill in the password field"),
		array("signup_verify_pass","verify password should match password"),
		array("signup_fname","please fill in the first name"),
		array("signup_lname","please fill in the last name"),
		array("signup_mobile","please fill in the mobile no field")
	);
	
	$form->setFormData($data);
	$form->setRequired($required);
	$form->setSubmitText('Signup');
	print $form->renderForm();
	?>
	</body>
</html>
<?php 	
		}
}
?>