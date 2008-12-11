<?php
	
	class SessionController {
		
		public function create(){
			$user = User::find_by_login($_POST['user']['login']);
			if (!empty($user)) Authorization::authorize($user, $_POST['user']['password']);
			Authorization::redirect_to("/");
		}
		
		public function destroy(){			
			session_destroy();
			Authorization::redirect_to("/");
		}
	}
?>