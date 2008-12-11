<?php
	
	class Appartment extends ActiveRecord {
		
		#attributes		
		#public $name;
		
		public static $table_name = "Apartment";		
		public static $default_condition = "type = 'apartment'";		
		public static $default_order = " ORDER BY name";
		public static $default_dimension = "desc";
		
		#find
		public static function find($type, $conditions = "", $order = "", $dimension = ""){ 
			switch ($type){
				case "all":
					return self::find_all($conditions, $order, $dimension);
					break;
				default:
					if (is_int($type)) return self::find_by_id($type, $conditions);
			}					
		}
		
		public static function find_all($conditions = "", $order = "", $dimension = ""){			
			$conditions = "WHERE ".self::$default_condition.(empty($conditions) ? "" : " AND ($conditions)");
			return parent::find_all(self::$table_name, __CLASS__, $conditions.self::order($order).self::dimension($dimension));
		}		
				
		public static function find_by_sql($sql){
			return parent::find_by_sql($sql, __CLASS__);
		}
		
		public static function find_by_id($id, $conditions = ""){
			$conditions = self::$default_condition.(empty($conditions) ? "" : " AND ($conditions)");
			$objects =	parent::find_by_sql("SELECT * FROM ".self::$table_name." WHERE (id = '$id') AND ($conditions) ".self::$default_order." LIMIT 1", __CLASS__);
			return $objects[0];
		}
		
		private static function order($order){
			return (empty($order) ? self::$default_order : " ORDER BY $order");
		}
		
		private static function dimension($dimension){
			return (empty($dimension) ? " ".self::$default_dimension : " ".$dimension);
		}
		
		private static function conditions($conditions){
			if (empty(self::$default_condition) && empty($conditions)) return "";
			else return "WHERE ".self::$default_condition.(empty($conditions) ? "" : " AND ($conditions)");						
		}
	}
?>