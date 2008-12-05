<?	
	define('DIR_SEP', DIRECTORY_SEPARATOR);		
	define('SITE_PATH', preg_replace('{config/config\.php}', '', __FILE__));
	define('CORE_PATHS', "return ".var_export(array('models', 'core', 'lib', 'controllers'), 1).";");
	define('FILE_EXT', '.php');
	define('SITE_URL', "http://".$_SERVER['HTTP_HOST']);

	require_once(SITE_PATH."lib".DIR_SEP."utils".FILE_EXT);
?>