<?php
	class Authorization {
		
		public static $current_user;
		/**
		 * Checking loggin in
		 * @author Ivan Garmatenko <cheef.che at gmail.com>
		 * @return unknown
		 */
		public static function login_required(){			
			if (self::is_logged()){
				return true;
			} else return (self::login_by_session() || self::login_by_http_basic());
		}
		
		public static function login_by_session(){
			$user = User::find_by_id(Session::$current_session->data);
			if (empty($user)) return false;
			else {
				self::$current_user = $user;
				return true;
			}			
		}
		
		private static function login_by_http_basic(){
			if (!self::login_typed()) return self::access_denied();
			$user = User::find_by_login($_SERVER['PHP_AUTH_USER']);			
			return self::authorize($user, $_SERVER['PHP_AUTH_PW']);
		}
		
		/**
		 * Cheching access by role or special conditions
		 * @author Ivan Garmatenko <cheef.che at gmail.com>
		 * @param string $role_title
		 * @param User class instance $owner
		 */
		public static function permit_to($role_title, $owner = NULL){
			$user = self::current_user();
			
			if (($user->has_role("admin") || ($user == $owner)) && !empty($owner));
			else self::redirect_to("/admin");
		}	
		
		/**
		 * Authorization method
		 * @author Ivan Garmatenko <cheef.che at gmail.com>
		 * @param User class instance $user
		 * @param string $password
		 * @return boolean
		 */
		public static function authorize($user, $password){
			if (!empty($user) && self::is_compare($user, $password)) {
				self::$current_user = $user;
				Session::$current_session->update($user->id);				
				return true;
			} else return false;
		}
		
		/**
		 * Compare password		 
		 * @author Ivan Garmatenko <cheef.che at gmail.com>
		 * @param User class instance $user
		 * @param string $password
		 * @return boolean
		 */
		public static function is_compare($user, $password){
			return $user->password == md5($user->salt.$password);
		}
		
		/**
		 * Echo 401 Error message
		 * @author Ivan Garmatenko <cheef.che at gmail.com>
		 * @param string $message
		 */
		public static function access_denied($message = "UNAUTHORIZED"){			
			 header('WWW-Authenticate: Basic realm="Administrative interface"');
    	 header('HTTP/1.0 401 Unauthorized');
    	 echo $message;
		}		
		
		/**
		 * Generates salt
		 * @author Ivan Garmatenko <cheef.che at gmail.com>
		 * @param string $password
		 * @return md5 string
		 */
		private static function salt($password){
			return md5($password);
		}
		
		/**
		 * Redirects to custom url
		 * @author Ivan Garmatenko <cheef.che at gmail.com>
		 * @param string $url
		 */
		public static function redirect_to($url){
			header("Location:$url");
		}
		
		/**
		 * Generate crypted password from salt and clear password
		 * @author Ivan Garmatenko <cheef.che at gmail.com>
		 * @param sha1 string $salt
		 * @param string $password
		 * @return string (crypted password)
		 */
		private static function password($salt, $password){
			return md5($salt . $password);
		}
		
		/**
		 * Generate salt and password
		 * @author Ivan Garmatenko <cheef.che at gmail.com>
		 * @param string $password
		 * @return hash with salt and crypted password
		 */
		public static function crypt($password){
			$salt = self::salt($password);
			return array("password" => self::password($salt, $password), "salt" => $salt );
		}
		
		/**
		 * Return current logged user
		 * @author Ivan Garmatenko <cheef.che at gmail.com>
		 * @return User class instance
		 */
		public static function current_user(){
			self::$current_user = User::find_by_login($_SERVER['PHP_AUTH_USER']);
			if (login_typed) return User::find_by_login($_SERVER['PHP_AUTH_USER']);
		}
		
		/**
		 * Checking login and password type via apache
		 * @author Ivan Garmatenko <cheef.che at gmail.com>
		 * @return boolean
		 */
		private static function login_typed(){
			return (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']));
		}
		
		public static function is_logged(){
			return !empty(self::$current_user);
		}
	}
?>