<?php require 'mail.header.php'?>
<tr><td colspan="2" bgcolor="#ffffff" style="background:#ffffff; border-top:1px solid #dddddd; border-left:1px solid #dddddd; border-right:1px solid #dddddd; padding:1px;">
<div style="padding:30px 50px;font-size:16px; font-weight:bold; background:#444444; color:#ffffff;">Welcome to <a href="">Trackti</a></div>
</td>
</tr>
<tr>
	<td colspan="2" bgcolor="#FFFFFF" style="background:#ffffff; border:1px solid #dddddd; border-top:none; color:#444444;">
		<table cellpadding="0" cellspacing="0" border="0" width="490" align="center" style="text-align:left">
			<tr><td><img src="<?php echo APP_URL; ?>/public/images/mail/blank.gif" alt="" height="20" width="1" style="display: block;padding: 0;border: 0 none;margin: 0;"></td></tr>
			<tr>
				<td>
					<div style="color:#444444; font-size: 14px; margin: 10px 0; line-height:1.5;">Dear <?php echo $toname?>,</div>
						<div style="color:#444444; font-size: 14px; margin: 10px 0; line-height:1.5;">You have successfully registered in the Trackti. We are working for get confirmed your information.You will be notified after the confirmation.</div>
					<div style="color:#444444; font-size: 14px; margin: 10px 0; line-height:1.5;">Thanks for your patience.</div>
					<div style="color:#444444; font-size: 14px; margin: 10px 0; line-height:1.5;">Sincerely,</div>
				</td>
			</tr>
			<tr><td height="60" valign="middle"><img src="<?php echo APP_URL ?>/public/images/logo.png" alt="Trackti" height="40" width="100" style="display:block; padding: 0;border: 0 none;margin: 0; "></td></tr>
			<tr><td><img src="<?php echo APP_URL; ?>/public/images/mail/blank.gif" alt="" height="20" width="1" style="display: block;padding: 0;border: 0 none;margin: 0;"></td></tr>
		</table>
	</td>
</tr>
<?php require 'templates/mail.footer.php'?>