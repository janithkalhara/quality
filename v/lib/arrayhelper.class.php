<?php
class Arrayhelper{
	
	public static function arrayKeySearch($array,$criteria){
			$flag=-1;
			$tracker=0;
			
		foreach ($array as $temp){
				$suspect=array_slice($temp, 0,2);
				
				if($suspect==$criteria){
					$flag=$tracker;
				}
			$tracker++;
		}
	return $flag;
	}
	
	
}


