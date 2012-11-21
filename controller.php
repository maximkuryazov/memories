<?php
	
	$CURRENT_USER = NULL;
	
	class Controller {
		
		public function parse() {
		
		global $CURRENT_USER;
		
			// is user authorized?
			
			$user_is_authorized = false;
			$checking_user = User_Model::get_user_by_session(session_id());
			if ( count($checking_user) > 0 ) {		
				$CURRENT_USER = new User_Model($checking_user[0][1], $checking_user[0][2], true);
				$user_is_authorized = true;
			}
						
			// authorization
			
			if ( !isset($_POST["confirm_password"]) && isset($_POST["password"]) ) {
				$CURRENT_USER = new User_Model($_POST["login"], $_POST["password"]);
				if ( !empty( $CURRENT_USER -> ID ) ) {
					Core::render(true, "", $CURRENT_USER -> ID);
				}
				else {
					Core::render(false, "Неверный логин или пароль.");
				}
			}
			elseif ( isset($_POST["confirm_password"]) ) {
				
				// registration
				
				$check_pass = $_POST["password"] !== "";
				$confirm_pass = $_POST["confirm_password"] == $_POST["password"];
				$login_is_correct = preg_match("~^[a-zа-я0-9]{3,10}$~i", $_POST["login"]);
			
				if ( $check_pass && $confirm_pass && $login_is_correct ) {
					if ( User_Model::create_user() ) {
						Core::render(true, "Регистрация прошла успешно!");
					}
					else {
						Core::render(false, "Такой логин уже занят.");
					}
				} else {	
					Core::render(false, "Поля заполнены некорректно.");
				}
			
			}
			
			// manage bookmarks
			
			if ( isset($_REQUEST["method"]) ) {
				
				if ($user_is_authorized) {
				
					$destination = split("[/]", $_REQUEST["method"]);
					
					if ( $destination[0] == "user" ) {
						switch ( $destination[1] ) {
							case"get_all_memories":
								echo json_encode($CURRENT_USER -> get_all_memories());
							break;
							case "add_memory": 
								echo json_encode( $CURRENT_USER -> add_memory($_POST["title"], $_POST["bookmark"]) );
							break;
							case "remove_memory":
								$CURRENT_USER -> remove_memory($_GET["id"]);
							break;
							case "logout":
								echo json_encode( $CURRENT_USER -> logout() );
							break;
						}
					} 
					elseif ( $destination[0] == "memory" ) {
						switch ( $destination[1] ) {
							case "edit_memory":
								echo json_encode( Memory::edit($_POST["title"], $_POST["bookmark"]) );
							break;
						}
					}
				}
				
			}
			
		}
	}
	
?>