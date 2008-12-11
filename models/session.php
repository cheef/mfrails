<?php
	class Session extends ActiveRecord {

		public static $current_session = NULL;
		public $data, $id;
		public static $table_name = "sessions";		
		public static $default_condition = "";		
		public static $default_order = " ORDER BY created_at";
		public static $default_dimension = "desc";		
		
		public function save(){			
			self::$db->query("INSERT INTO ".self::$table_name."(id, data, expires_at, created_at) VALUES ('$this->id', '$this->data', now(), now())");
			self::$current_session = $this;
		}
		
		public static function open($path, $name){			
			return true;
		}
		
		public static function close(){			
			return true;
		}
		
		public static function read($id){			
			$session = Session::find_by_id($id);			
			if (!empty($session)) {
				self::$current_session = $session;
				if (!empty($session->data)) Authorization::$current_user = User::find((int) $session->data);
				return $session->data;						
			} else return '';
		}
		
		public static function write($id, $data){
			$user = Authorization::current_user();
			$session = new Session(array("id" => $id, "data" => (empty($user) ? "" : $user->id)));
			$session->save();			
			return true;
		}
		
		public static function destroy($id){			
			Authorization::$current_user = NULL;
			print "DELETE FROM ".self::$table_name." where id = '$id'";
			self::$db->query("DELETE FROM ".self::$table_name." where id = '$id'");
			return true;
		}
		
		public static function gc(){
			#self::$db->query("DELETE FROM ".self::$table_name." where expired_at < now()");
			return true;
		}
		
		public static function find($type, $conditions = "", $order = "", $dimension = ""){ 
			switch ($type){
				case "all":
					return self::find_all($conditions, $order, $dimension);
					break;
				default:
					if (is_int($type)) return self::find_by_id($type, $conditions);
			}					
		}
		
		public function update($data){
			self::$db->query("UPDATE ".self::$table_name." SET data = $data WHERE id = '$this->id'");
			$this->data = $data;
		}
		
		public static function find_by_id($id, $conditions = ""){			
			$objects =	parent::find_by_sql("SELECT * FROM ".self::$table_name." WHERE (id = '$id') LIMIT 1", __CLASS__);
			return $objects[0];
		}		
	}
?>