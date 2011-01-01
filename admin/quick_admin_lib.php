<?php

	/*
	 * @author: Andrew Horsman | MMRambotics
	 * @description: Quick alternative to HTTP Basic Authentication with sessions.
	 */

	session_start();

	/*
	 * Group of helper functions to create an alternative to HTTP Basic Authentication.
	 */
	class QuickAdmin {
	
		/*
		 * Redirects the user to the panel page if not logged in.
		 */
		public function redirectIfNotLoggedIn() {
			if (!self::isLoggedIn())
				self::redirect();
		}
		
		/*
		 * Redirects the user to the panel page.
		 */
		public function redirect($page = "panel.php") {
			header("Location: http://mmrambotics.ca/admin/$page");
			die();
		}
		
		/*
		 * Logs the user out.
		 */
		public function logout() {
			self::reset_session();
			self::redirect();
		}
		
		/*
		 * Clears the two session variables.
		 */
		public function reset_session() {
			unset($_SESSION['authenticated']);
			unset($_SESSION['authentication_date']);
		}
	
		/* 
		 * Returns true if the `authenticated` session is 'true' and if the `authentication_date` is a valid, recent timestamp.
		 */
		public function isLoggedIn() {
			if ($_SESSION['authenticated'] != 'true')
				return false;
				
			return self::isValidAuthDate();
		}
		
		/*
		 * Sets the session if the attempted login credentials are correct.  Returns false if attempted credentials are incorrect.
		 */
		public function attemptLogin($user, $pass) {
			$credentials = explode('::', trim(file_get_contents(dirname(__FILE__) . "/../../db/admin_credentials.txt")));
			
			if ($user == $credentials[0] && $pass == $credentials[1]) {
				$_SESSION['authenticated']       = 'true';
				$_SESSION['authentication_date'] = date("U");
				
				return true;
			} else {
				return false;
			}
		}
		
		/*
		 * Returns true if the stored session date is within a 24 hour window of the current date.
		 */
		public function isValidAuthDate() {
			if (!isset($_SESSION['authentication_date']))
				return false;
				
			$sessionDate = (int)$_SESSION['authentication_date'];
			$currentDate = (int)date("U");
			
			if ($sessionDate + 86400 < $currentDate) {
				self::reset_session();
				return false;
			} else {
				return true;
			}
		}
	
	}

?>