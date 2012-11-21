<?php
	class User_Model {
		
		private $info;
		private $db;
		
		public function __construct($login, $password, $already_md5) {
			global $DB;
			$this -> db = $DB;
			if(!$already_md5) $password = md5($password);
			$this -> info = $DB -> query("SELECT * FROM `users` WHERE `login` = '{$login}' AND `password` = '{$password}'");
			$this -> ID = $this -> info[0][0];
			$this -> login = $this -> info[0][1];
			$this -> password = $this -> info[0][2];
			$session_id = session_id();
			$this -> db -> exec("UPDATE `users` SET `sessid` = '{$session_id}' WHERE `ID` = " . $this -> ID);
		}
	
		public static function create_user() {
			global $DB;
			$password = md5($_POST["password"]);
			$test = $DB -> query("SELECT * FROM `users` WHERE `login` = '{$_POST["login"]}'");
			if ( isset($test[0]) ) {
				return false;
			}
			@$DB -> exec("INSERT INTO `users`(`login`, `password`) values('{$_POST["login"]}', '$password')");
			return true;
		}
		
		public static function get_user_by_session($session_id) {
			global $DB;
			return $DB -> query("SELECT * FROM `users` WHERE `sessid` = '{$session_id}'");
		}
		
		public function get_all_memories() {
			return $this -> db -> query("SELECT * FROM `memories` WHERE `user` = '{$this -> ID}'");
		}
		
		public function add_memory($title, $bookmark) {
			$is_url_correct = "~(?:(?:ftp|https?)?://|www\.)[a-z_.]+?[a-z_]{2,6}(:?/[a-z0-9\-?\[\]=&;#]+)?~i";
			if ( preg_match($is_url_correct, $bookmark) ) {
				$this -> db -> exec("INSERT INTO `memories`(`user`, `title`, `bookmark`) values('{$this -> ID}', '$title', '$bookmark')");
				return Array("result" => true, "message" => "Закладка успешно добавлена!");
			}
			return Array("result" => false, "message" => "Введён некорректный URL!");
		}
		
		public function remove_memory($memory_id) {
			$this -> db -> exec("DELETE FROM `memories` WHERE `ID` = $memory_id AND `user` = '{$this -> ID}'");
		}
		
		public function logout() {
			$this -> db -> exec("UPDATE `users` SET `sessid` = '' WHERE `ID` = '{$this -> ID}'");
			session_unset();
			$_SESSION = Array();
			return Array( "result" => session_destroy() );
		}
		
		public $login;
		public $passsword;
		public $ID;
		
	}
?>