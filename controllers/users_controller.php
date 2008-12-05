<?php
	class UsersController {
		
		public $layout = "admin";
		
		public function index(){
			$users = User::find("all");
			$this->render("index");
		}
		
		public function edit(){			
		}
		
		private function render($file){
			$current_template = $this->controller_path().$file.".html";
			include($this->current_layout());			 
		}
		
		private function controller_path(){
			return SITE_PATH."views".DIR_SEP."users".DIR_SEP;
		}
		
		private function current_layout(){
			return SITE_PATH."views".DIR_SEP."layouts".DIR_SEP.$this->layout.".html";
		}
		
	}
?>