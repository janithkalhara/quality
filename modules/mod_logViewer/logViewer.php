<?php 
defined("HEXEC") or die("Restrited Access.");
?>
<div style="min-height:370px;font-size:12px">
<form action="home.php?option=mod_logViewer" onsubmit="return confirm('Are you sure to clear the log?')" method="post" style="margin-bottom:20px">
<input type="submit" value="Clear Log" class="button" style="padding:5px 15px 5px 15px; color:#fff;background:#3B5998;height:30px"/> 
<input type="hidden" name="task" value="clear"> 
</form>



<?php
$log=new Logger("logfile.log");
if(isset($_POST['task'])){
	
	$log->clear_log();
	
}




$log_content=$log->get_log_content();
if(isset($log_content)){
foreach ($log_content as $temp){
	//print "length".strlen($temp)."<br>";
	if(strlen($temp)==18){
		print "<br>";
		print "<strong>".$temp."</strong>";
		print "<br>";
		
	}else{
		print $temp;
		print "<br>";
	}
}
}

?>

</div>