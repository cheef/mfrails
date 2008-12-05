<?php	
		
	class ActiveRecord extends AbstractClass {
		
		static $table_name = NULL;
		static protected $db = NULL;
		static public $result = NULL;
		public $id;
		
		public function ActiveRecord($data = ""){
			if (!empty($data))
				foreach ($data as $field => $value){
					$field = strtolower(preg_replace("/(\w)([A-Z]){1}/", "$1_$2", $field));
					if ($field == 'i_d') $field = "id";
					eval("return $"."this->".$field." = '$value';");
				}
		}		
		
		#find
		public static function find($db){			
			if (!empty($db)) self::$db = $db;
		}	
		
		public static function find_all($table_name = "", $klass = "", $conditions = ""){
			return self::find_by_sql("SELECT * FROM ".$table_name." ".$conditions, $klass);
		}
		
		public static function find_by_sql($sql, $klass = ""){
			self::connect_to_db_or_continue();									
			return self::fetch_query($sql, $klass);
		}
		
		#fetch result
		protected static function fetch_query($sql, $klass = ""){
			self::query_until_result($sql);			
			return self::fetch($klass);
		}
		
		protected static function fetch($klass){
			$collection = array();
			while ($data = self::$db->fetch(self::$result))
				$collection[] = eval("return new $klass($"."data);");
			self::$result = NULL;
			return $collection;
		}
		
		#connection path
		protected static function establish_connection(){			
			self::$db = new DataBase(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		}
		
		protected static function connect_to_db_or_continue(){
			if (!self::is_connected()) self::establish_connection();
		}
		
		protected static function is_connected(){			
			return !empty(self::$db);
		}
		
		#result caching
		protected static function query_until_result($sql){
			if (empty(self::$result)) self::$result = self::$db->query($sql);
			return self::$result;
		}
		
		#queries
		public function query($sql){
			self::connect_to_db_or_continue();
			self::$db->query($sql);
		}
		
		
	}
		
?>