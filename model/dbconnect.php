<?php
	class DB_Connect 
	{
		function __construct($host, $login, $password, $db_name) 
		{
			$this -> DB = new PDO("mysql:host=" . $host . ";dbname=" . $db_name, $login, $password);
		}
		public function query($sql_expression) 
		{
			try 
			{
				$result = $this -> DB -> query($sql_expression);
				return $result -> fetchAll();
			}
			catch(PDOException $error) 
			{
				die("Error: " . $error -> getMessage());
			}
		}
		public function exec($sql_expression, $error_callback) 
		{
			try
			{
				if (!$this -> DB -> exec($sql_expression)) 
				{
					if (is_callable($error_callback)) $error_callback();
				}
				else return true;
			}
			catch(PDOException $error) 
			{
				die("Error: " . $error -> getMessage());
			}
		}
		public function get_db() 
		{
			return $this -> DB;
		}
		public function transaction($callback) 
		{
			$this -> DB -> beginTransaction();
			if (is_callable($callback)) $callback();
			$this -> DB -> commit();
		}
		private $DB;
	}
	$DB = new DB_Connect("db01.hostline.ru", "vh43058_Maxman", "3225386", "vh43058_syntax");
?>
