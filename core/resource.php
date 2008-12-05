<?php 
	class Resource {
		public $db;
		public function Resource(){
			$this->db = new DataBase(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		}
	}
?>