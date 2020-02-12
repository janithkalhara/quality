<?php

class frameWork{
	
	public function frameWork(){
		
		
	}
	
	public function redirect($url,$message){
		
		header("location:$url");
		print "<script type='text/javascript'>";
		print "$('#highlight-error').faedIn('slow');";
		print "$('#highlight-error').html('".$message."')";
		print  "</script>";
		
	}
	public function putMessage($message,$type){
		
		print "<script type='text/javascript'>";
		
		print "$('#highlight-error').fadeIn('slow').delay(8000).fadeOut('slow') ;";
		print "$('#highlight-error').attr('class','highlight-$type');";
        print "$('#highlight-error').html('".$message."')";
    
       print "</script>";
        $this->timeOutAlert();
        
	}
	
	public  function setTitle($title){
		$base=$title."| Quality Analysis System  ";
		
		print "<script type='text/javascript'>";
       
        print "document.title='".$base."'";
        print  "</script>";
		
	}
	
	private function timeOutAlert(){
		
		
		
		
	}
}


?>