<?php

/*
 * calling for basic configurations of the application.
 */
require_once ROOT.DS."config".DS."config.php";
/*
 * calling for basic surrounding functions of the application.
 */
require_once ROOT.DS."lib".DS."frame.php";
/*
 * calling for starter of the application.
 */
require_once ROOT.DS."lib".DS."starter.php";

App::init($url);


function __autoload($className) {
	$classFile = strtolower($className).'.class.php';

	if(file_exists(APP_ROOT.'/lib/'.$classFile)) {
		require_once APP_ROOT.'/lib/'.$classFile;
		return true;
	}
	if(file_exists(APP_LIB_PATH.$classFile)) {
		require_once APP_LIB_PATH.$classFile;
		return true;
	}

	$tracker = substr($className, 0,strlen($className)-10);
	$controller = strtolower($tracker).'.controller.php';

	if(file_exists(APP_ROOT.'/components/controllers/'.$controller)) {
		require_once APP_ROOT.'/components/controllers/'.$controller;
		return true;
	}

	if(file_exists(APP_ROOT.'/components/models/'.strtolower($className).'.php')) {
		require_once APP_ROOT.'/components/models/'.strtolower($className).'.php';
		return true;
	}

}