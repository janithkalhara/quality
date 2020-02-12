<?php
date_default_timezone_set('Asia/Kolkata');

class Logger{
	
	private $logfile;
	
	public function Logger($path){
		$this->logfile=$path;
	}
	public function log($time,$message){
		$message_pref="";
		$last_date=$this->get_last_date();
		$today=time();
		$spl1=explode(" ", $last_date);
		$date1 = $spl1[0];
		$date2 = date('Y-m-d');
		$diff = abs(strtotime($date2) - strtotime($date1));
		$years = floor($diff / (365*60*60*24));
		$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
		$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
		if($days>=1){
			$message_pref.="\n";
			$message_pref.="Date : ".date("Y-m-d");	
			$message_pref.="\n";
		}else{
			$message_pref.="\n";
		}
		$fh = fopen($this->logfile, 'a'); 
		$log_string=$message_pref.$time."\t".$message;
		fwrite($fh, $log_string); 
		
	}
	public function error_log($time,$writable){
		$fh = fopen($this->logfile, 'a'); 
		$log_string=$message_pref.$time."\t".$message;
		fwrite($fh, $log_string); 
	}
	public function get_last_date(){
		$last=$this->read_file($this->logfile, 1);
		if($last!="" || $last!=null){
			$date=substr($last[0],0,20);
			return $date;
		}else return null;
	}
	public function read_file($file, $lines) {
	    //global $fsize;
	    $handle = fopen($file, "r");
	    $linecounter = $lines;
	    $pos = -2;
	    $beginning = false;
	    $text = array();
	    while ($linecounter > 0) {
	        $t = " ";
	        while ($t != "\n") {
	            if(fseek($handle, $pos, SEEK_END) == -1) {
	                $beginning = true; 
	                break; 
	            }
	            $t = fgetc($handle);
	            $pos --;
	        }
	        $linecounter --;
	        if ($beginning) {
	            rewind($handle);
	        }
	        $text[$lines-$linecounter-1] = fgets($handle);
	        if ($beginning) break;
	    }
	    fclose ($handle);
	    return array_reverse($text);
	}

	public function get_log_content(){
		$content=array();
		$file_handle = fopen($this->logfile, "r");
		while (!feof($file_handle)) {
			$line = fgets($file_handle);
			array_push($content, $line);
		}
		fclose($file_handle);
		return $content;
		
	}
	public function clear_log(){
		shell_exec("mv ".$this->logfile." log_history/".date("Y-m-d_h:i:s")."_logfile.log");
		file_put_contents("logfile.log", "");
	}
}
?>