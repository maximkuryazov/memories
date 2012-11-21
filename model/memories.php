<?php
	
	class Memory {
		
		public static function edit($title, $bookmark) {
			global $CURRENT_USER, $DB;
			$is_url_correct = "~(?:(?:ftp|https?)?://|www\.)[a-z_.]+?[a-z_]{2,6}(:?/[a-z0-9\-?\[\]=&;#]+)?~i";
			if ( preg_match($is_url_correct, $bookmark) ) {
				$DB -> exec("UPDATE `memories` SET `title` = '$title', `bookmark` = '$bookmark' WHERE `user` = '{$CURRENT_USER -> ID}'");
				return Array("result" => true);
			}
			return Array("result" => false, "message" => "Введён некорректный URL!");
		}
		
	}
	
?>