<?php
	session_start();
	
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Content-type: application/json');
	
	require("model/dbconnect.php");
	require("model/user.php");
	require("model/memories.php");
	require("controller.php");

	class Core {
	
		public static function render($result, $message, $user_id) {
		
			echo json_encode(
				Array(
					"result" => $result,
					"message" => $message,
					"userID" => $user_id
				)
			);
			
		}
		
		public function init() {
	
			$controller = new Controller();
			$controller -> parse();
			
		}
		
	}
	
	$core = new Core();
	$core -> init();
?>