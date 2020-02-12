<?php
class Log extends Object{

	public static function put($str){
		error_log(APP_NAME.' - LOG - '.$str);
	}


}