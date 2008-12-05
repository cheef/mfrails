<?php 

	class DataBase {
		
		protected $name, $handler, $sql;
		
		public function DataBase($host, $user, $pass, $db) {						
			$this->connect($host, $user, $pass) or die("database connection error");
			$this->select_db($db) or die("database not exists");
		}
		
		private function connect($host, $user, $pass){
			$this->handler = mysql_connect($host, $user, $pass);
			return $this->handler;
		}
		
		private function select_db($name){
			return mysql_select_db($name); 
		}	
		
		public function query($sql = ""){			
			return mysql_query(empty($sql) ? $this->sql : $sql);
		}		
		
		public function fetch($query){
			return mysql_fetch_assoc($query);
		}
	}
		
?>