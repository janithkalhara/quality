<?php
class UsersController extends Controller {
	
 public function index() {
    	if(!$this->__sessionUser instanceof User) { header('Location:/signin');exit(); }
    	$users = User::getUsers();
		$template = __DIR__.'/../views/users/user.list.php';
    	$__page = (object)array('title' => 'Quality Analysis System',
    						'sections' => array($template),
    						'assets' => array(
    									array('STYLE', APP_CDN.'/css/select2.css','HEAD'),
										array('STYLE', APP_CDN.'/css/datepicker.css','HEAD'),
										array('STYLE', APP_CDN.'/css/base.css','HEAD'),
										array('SCRIPT', APP_CDN.'/js/bootstrap-datepicker.js','HEAD'),
										array('SCRIPT', APP_CDN.'/js/jquery.validate.js','HEAD'),
										array('SCRIPT', APP_CDN.'/js/jquery.form.js','HEAD'),
    									array('SCRIPT', APP_CDN.'/js/select2.min.js','HEAD'),
										array('SCRIPT', APP_CDN.'/js/base.js','HEAD'),
    							)	
    				
    			);
    	
    	require_once APP_TEMPLATE_PATH.'/base.php';
    }
	
}