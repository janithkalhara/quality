<?php

class MailHelper{
	
	
	public function __construct(){
		
		
	}
	
	public static function sendMail($data){
		
		$mail=new PHPMailer();
		
		
			$mail->IsSMTP(true);
			$mail->SMTPDebug = 0;
			$mail->SMTPAuth=true;
			$mail->SMTPSecure = 'ssl';
			$mail->Host=APP_SMTP_HOST;
			$mail->Port=APP_SMTP_PORT;
			$mail->Username=APP_SMTP_UNAME;
			$mail->Password=APP_SMTP_PASSWORD;
			$mail->setFrom(APP_MAIL_FROM_MAIL,APP_MAIL_FROM_NAME);
			$mail->Subject=$data['subject'];
			$mail->Encoding = 'base64'; //'quoted-printable';
			
			$mail->AddReplyTo(APP_MAIL_REPLYTO,APP_MAIL_FROM_NAME);
			$mail->MsgHTML((string)$data['content']);
			require 'includes/html2text.inc.php';
			$mail->AltBody=convert_html_to_text((string)$data['content']);
			if(is_array($data['to'])){
				foreach ($data['to'] as $address){
					$mail->AddAttachment($address);
				}
			}else{
				$mail->AddAddress($data['to'],$data['toname']);
			}
			
			if($mail->Send()){
				error_log('mail sent');
				$mail->SmtpClose();
				return true;
			}else{
				$mail->SmtpClose();
				error_log('error in mail sending');
				return $mail->ErrorInfo;
			}
			
			
		
	}
	
	public static function getContent($path,$data){
		
		if($data){
			extract($data);
			require 'templates/'.$path;
			$d=ob_get_contents();
			file_put_contents('/tmp/teeeeee', $d);
			ob_end_clean();
			return $d;
		}
		
		
	}
	
}
?>