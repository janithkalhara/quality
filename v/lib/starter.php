<?php
session_start();

class App {
	
	public static function init($request_url) {
		try {
			self::setReporting();
			self::removeMagicQuotes();
			self::unregisterGlobals();
			extract(Request::getController($request_url));
			if(!class_exists($controller)) { throw new Exception($controller.' Class not found',404); }
			$ref_class = new ReflectionClass($controller);
			$instance = $ref_class->newInstance(null);
		
			if(!method_exists($instance, $action)) { throw new Exception('Method not found',404); }
			$docComment = $ref_class->getMethod($action)->getDocComment();
		
			if($docComment) {
				$access = Parser::parse($docComment)->get('access');
				if(strtolower($access) == 'private' || strtolower($access) == 'protected') {
					$instance->isAuthorized();
		
				}
			}
			$instance->$action();
			return $instance;
		
		}
		catch (Exception $e) {
			switch ($e->getCode()) {
				case 401:
					if($instance->getRequest()->isAjax()) {
						header('HTTP/1.1 401 Not Authorized');
						header('Content-type:application/json');
						echo json_encode(array(
										'success' => false,
										'message' => 'Not Authorized.',
										'code' => 401,
										'path' => '/signin?__backto='.urlencode($instance->getRequest()->getReferrer())));
					}
					else {
						header('HTTP/1.1 401 Not Authorized');
						$backto = is_null($backlink = $instance->getRequest()->getBackLink()) ? '?__backto=' . urlencode($backlink) : '';
						header('Location:/index.php'.$backto);
					}
					exit();
						
					break;
				case 404:
					Factory::show404();
					break;
				default:
					echo 'Exception : '.$e->getCode().' '.$e->getMessage();
					break;
			}
		}
	}
	
	public static function setReporting() {
		if (DEV_MOD == true) {
			//   error_reporting(E_ALL & E_STRICT);
			ini_set("display_errors", "On");
		}
		else {
			error_reporting(E_ALL);
			ini_set("display_errors", "Off");
			ini_set("log_errors", "On");
			ini_set("error_log", ROOT . DS . "tmp" . DS . "logs" . DS . "error_log");
		}
	}
	

	public static function stripSlashesMore($value) {
		$value = is_array($value) ? array_map("stripSlashesMore", $value) : stripslashes($value);
		return $value;
	}
	
	public static function removeMagicQuotes(){
		if (get_magic_quotes_gpc()) {
			stripSlashesMore($_GET);
			stripSlashesMore($_POST);
			stripSlashesMore($_COOKIE);
		}
	}
	
	public static function unregisterGlobals() {
		if (ini_get('register_globals')) {
			$array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
			foreach ($array as $value) {
				foreach ($GLOBALS[$value] as $key => $var) {
					if ($var === $GLOBALS[$key]) {
						unset($GLOBALS[$key]);
					}
				}
			}
		}
	}
	
}
?>