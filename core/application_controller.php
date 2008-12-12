<?php
	class ApplicationController {
		public $current_user, $current_session, $params;
		
		public static function delegate($controller_name, $id, $format){
			eval("\$controller = new ".self::controller_name($controller_name)."(array(\"id\" => \$id, \"format\" => \$format));");
			$controller->execute();			
		}
		
		public function redirect_to(){
			
		}	
		
		public function current_user(){
			
		}
		
		public function current_session(){			
		}
		
		static private function controller_name($controller){
			return RubyString::camelcase($controller)."Controller";
		}
	}
?>