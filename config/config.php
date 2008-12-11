<?	
	define('DIR_SEP', DIRECTORY_SEPARATOR);		
	define('SITE_PATH', preg_replace('{config/config\.php}', '', __FILE__));
	define('CORE_PATHS', "return ".var_export(array('models', 'core', 'lib', 'controllers'), 1).";");
	define('FILE_EXT', '.php');
	define('SITE_URL', "http://".$_SERVER['HTTP_HOST']);

	require_once(SITE_PATH."lib".DIR_SEP."utils".FILE_EXT);
	
	ActiveRecord::$db = new DataBase(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	
	ini_set('session.save_handler', 'user');
	session_set_save_handler(
		array('Session', 'open'),
		array('Session', 'close'),
		array('Session', 'read'),
		array('Session', 'write'),
		array('Session', 'destroy'),
		array('Session', 'gc')
  );
  session_start();
  #debug(Authorization::$current_user);
?>#