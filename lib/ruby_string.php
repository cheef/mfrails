<?php
	class RubyString {
		
		public $value;
		
		public function RubyString($string){
			$this->value = $string;	
		}
		
		public function underscore(){
			return strtolower(preg_replace("/(\w)([A-Z]){1}/", "$1_$2", $this->value));
		}
				
		static function camelcase($str){			
			return mb_convert_case($str,  MB_CASE_TITLE);
		}
	}
?>