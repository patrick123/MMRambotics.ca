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
		 * Returns true if the `authenticated` session is 'true' and if the `authentication_date` is a valid, recent timestamp.
		 */
		public function isLoggedIn() {
			if ($_SESSION['authenticated'] != 'true')
				return false;
				
			return self::isValidAuthDate();
		}
		
		/*
		 * Returns true if the stored session date is within a 24 hour window of the current date.
		 */
		private function isValidAuthDate() {
			if (!isset($_SESSION['authentication_date']))
				return false;
				
			$sessionDate = (int)$_SESSION['authentication_date'];
			$currentDate = (int)date("U");
			
			if ($sessionDate + 86400 > $currentDate) {
				unset($_SESSION['authentication_date']);
				unset($_SESSION['authenticated']);
				
				return false;
			} else {
				return true;
			}
		}
	
	}

?>