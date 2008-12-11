<?php
	class ObjectsController {
		
		public function ObjectsController(){			
		}
		
		public function summary_page(){
			$apartments = Appartment::find_all();
			$offices = Office::find("all");
			
			render_partial("apartments", "admin".DIR_SEP."index.html", array("apartments" => $apartments));	
			render_partial("offices", "admin".DIR_SEP."index.html", array("offices" => $offices));			
		}
	}
?>