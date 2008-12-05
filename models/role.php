<?php
	class Role extends ActiveRecord {
		
		#attributes
		public $name, $created_at;		
		
		public static $table_name = "roles";
		
		#find
		public static function find($type, $conditions = ""){						
			switch ($type){
				case "all":
					return self::find_all();
					break;
			}					
		}		
		
		public static function find_all($db = ""){
			parent::find($db);
			return parent::find_all(self::$table_name, __CLASS__);
		}		
				
		public static function find_by_sql($sql, $db = ""){
			if (!empty($db)) parent::find($db);
			return parent::find_by_sql($sql, __CLASS__);
		}	

		public static function agent(){
			return new Role(array('name' => 'agent', 'id' => 2));
		}
	}
?>