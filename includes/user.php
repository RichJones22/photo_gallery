<?php 
require_once(LIB_PATH.DS."database.php");

class User extends DatabaseObject  {
	
	protected static $table_name="users";
	
	public $id;
	public $username;
	public $password;
	public $first_name;
	public $last_name;
	

	public function full_name() {
		if(isset($this->first_name) && isset($this->last_name)) {
			return $this->first_name . " " . $this->last_name;
		} else {
			return "";
		}
	}
	
	public static function authenticate($username="", $password="") {
		global $database;
		$username = $database->escape_value($username);
		$password = $database->escape_value($password);
		
		$sql  = "select * from users ";
		$sql .= "where username = '{$username}' ";
		$sql .= "  and password = '{$password}' ";
		$sql .= "limit 1";
	
		$result_array = self::find_by_sql($sql);
		
		return !empty($result_array) ? array_shift($result_array) : false;
		
	}
	
	public function save() {
		return isset($this->id) ? $this->update() : $this->create(); 
	}
		
}
?>