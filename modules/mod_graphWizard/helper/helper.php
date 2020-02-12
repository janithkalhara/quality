<?php

class Helper{
	
	public static function myImplodeToString($array){
		$str="";
		for ($i=0;$i<count($array);$i++){
			$str.="'".$array[$i]."',";
			
			
		}
		
		return substr($str, 0,(strlen($str)-1));
		
	}
	
	
	
	
}





?>