<?php

	function debug($variable){
		print "<pre>";
		print_r($variable);
		print "</pre>";
	}
	
	function __autoload($class_name){
		
		require_once(SITE_PATH."lib".DIR_SEP."ruby_string".FILE_EXT);
		$filename = new RubyString($class_name.FILE_EXT);			
		$filename = $filename->underscore();
		
		foreach(eval(CORE_PATHS) as $path)
			if (file_exists(SITE_PATH.$path.DIR_SEP.$filename) != false) require_once(SITE_PATH.$path.DIR_SEP.$filename);			
	}
	
	function render_collection($collection, $variable, $controller, $partial){
		foreach($collection as $element) render_partial($controller, $partial, array($variable => $element));
	}
	
	function render_partial($controller, $partial, $locals){
		foreach($locals as $key => $value) eval("\$$key = \$value;");
		include(views_dir().$controller.DIR_SEP.$partial);
	}
	
	function views_dir(){
		return SITE_PATH."views".DIR_SEP;
	}	
		
?>