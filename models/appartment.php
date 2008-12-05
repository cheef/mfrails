<?php
	
	class Appartment extends ActiveRecord {
		
		#attributes		
		#public $name;
		
		public static $table_name = "Apartment";		
		public static $default_condition = "WHERE type = 'apartment'";
		public static $default_order = " ORDER BY name";
		
		#find
		public static function find($type, $db = "", $conditions = ""){
			if (empty($conditions)) $conditions = self::$default_condition;			
			parent::find($db);
			switch ($type){
				case "all":
					return self::find_all($conditions);
					break;
				default:
					if (is_int($type)) return self::find_by_id($type);
			}					
		}
		
		public static function find_all($conditions = ""){			
			if (empty($conditions)) $conditions = self::$default_condition;
			return parent::find_all(self::$table_name, __CLASS__, $conditions.$default_order);
		}		
				
		public static function find_by_sql($sql){
			return parent::find_by_sql($sql, __CLASS__);
		}
		
		public static function find_by_id($id){
			$objects =	parent::find_by_sql("SELECT * FROM ".self::$table_name." WHERE id = '$id' LIMIT 1", __CLASS__);
			return $objects[0];
		}
	}
?>