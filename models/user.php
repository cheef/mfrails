<?php
	
	class User extends ActiveRecord {
		
		#attributes
		public $name, $login, $password, $salt, $created_at, $updated_at;
		
		public static $table_name = "users";		
		
		#find
		public static function find($type, $db = "", $conditions = ""){
			parent::find($db);
			switch ($type){
				case "all":
					return self::find_all();
					break;
				default:
					if (is_int($type)) return self::find_by_id($type);
			}					
		}
		
		public static function find_all(){
			return parent::find_all(self::$table_name, __CLASS__);
		}		
				
		public static function find_by_sql($sql){
			return parent::find_by_sql($sql, __CLASS__);
		}
		
		public static function find_by_id($id){
			$users =	parent::find_by_sql("SELECT * FROM ".self::$table_name." WHERE id = '$id' LIMIT 1", __CLASS__);
			return $users[0];
		}
		
		public static function find_by_login($login){
			$users =	parent::find_by_sql("SELECT * FROM ".self::$table_name." WHERE login = '$login' LIMIT 1", __CLASS__);
			return $users[0];
		}		
	
		#roles
		public function has_role($name){
			$role = Role::find_by_sql("SELECT r.* FROM roles r JOIN roles_users ru ON r.id = ru.role_id where ru.user_id = $this->id AND r.name = '$name' limit 1");			
			return (empty($role[0]) ? false : true);
		}		
		
		public function roles($db = ""){			
			return Role::find_by_sql($db, "SELECT r.* FROM roles r JOIN roles_users ru ON r.id = ru.role_id where ru.user_id = $this->id");
		}
		
		public function roles_create($role){
			parent::query("INSERT INTO roles_users(role_id, user_id) VALUES ('$role->id', '$this->id')");
		}
	}
?>