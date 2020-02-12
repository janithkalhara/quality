<?php
class Auth {
	const USER_LOGGED_IN = 900;
	const USER_ALREADY_LOGGED_IN = 901;
	const USER_LOGGIN_FAILED = 902;
	const USER_NOT_FOUND = 903;
	
	public static function getSessionUser() {
		if(isset($_SESSION['session.user'])) {
			return User::getUser($_SESSION['session.user']['uname']);
		}
		return null;
	}
	
	public static function setSessionUser(User $user){
		$_SESSION['session.user'] = array(
									'name' => $user->getName(),
									'uname' => $user->getUserName(),
									'avatar' => $user->getAvatar(),
						);	
	}
	
	public static function authenticate($username,$password) {
		if(User::isUser($username)) {
			if(User::authUser($username, $password)) {
				$user = User::getUser($username);
				Auth::setSessionUser($user);
				throw new Exception('Successfully logged in.',self::USER_LOGGED_IN);
			}
			else {
				throw new Exception('Login failed. Username or password is wrong.',self::USER_LOGGIN_FAILED);
			}
		}
		else {
			throw new Exception('Not a valid user',self::USER_NOT_FOUND);
		}
		
	}
}
?>