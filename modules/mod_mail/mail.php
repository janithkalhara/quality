<link href="modules/mod_mail/css/mail.css" type="text/css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="libraries/textEditor/jquery.cleditor.css">
<script type="text/javascript" src="libraries/textEditor/jquery.cleditor.min.js"></script>
<script type="text/javascript">

$(function(){
	$('textarea#content-form').cleditor();
});




</script>
<div id="mailform" >
<?php 
require_once 'includes/smtp.class.php'; 

require_once 'includes/phpmailer.class.php';
require_once 'includes/mailhelper.class.php';
if(isset($_POST['task'])){
	$task=$_POST['task'];
	if($task=='feedback'){
		error_log('mailing ');	
		$subject=$_POST['subject'];
		$content=$_POST['content'];
		$by=$_SESSION['SESS_MEMBER_ID'];
		//mail 
		$data=array();
		
		$data['to']='pgmlmanoj@gmail.com';
		$data['toname']='Dforz';
		$data['subject']=$subject." -- Feedbadk from ".$by." Hayleys Quality analysis system.";
		$data['content']=$content;
		$data['tpl']='template.mail.php';
		if(MailHelper::sendMail($data)){
			echo '<p class=\'success alert\'>Hey!. Your feedback sent to the system admins successfully. They will consider about that. <br>Thank you for the feedback. </p>';
		}else{
			echo '<p class=\'error alert\'>Oops! We got something error. Could you please try again. <br> We are sorry for the inconvinience</p>';
		}
	}
}else{
	showForm();
}


?>






<?php 
function showForm(){


?>


 	   	<h4 >Feedback Form </h4>
        <form id="form1" name="form1" method="post" action="home.php?option=mod_mail">
		<table width="500" height="120" border="0" cellpadding="0" cellspacing="0">
 		<tr>
 		<td>
 	
 		<label><b>Subject</b> : </label>
 		</td><td><input type="text" style="width:200px" name="subject"/></td>
      	</tr>
      	<tr><td><b>Message</b></td><td><textarea cols="50" rows="4" name="content" id="content-form"></textarea>
        
        </td>
   		</tr>
   		<tr>
    	<td><input type="submit" value="Send the feedback " />
    	</td><td>
    	<input type="reset" value="Clear" />
        <input type="hidden" name="task" value="feedback" />
        </td>
  		</tr>
 
        </table>
 </form>

<?php }?>
</div>