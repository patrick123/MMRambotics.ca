<?php

	/*
	 * @author: Andrew Horsman | MMRambotics
	 * @description: Administration console.
	 */
	
	session_start();
	require_once("quick_admin_lib.php");

	function displayOrProcessLoginForm() {
		if (isset($_POST["user"]) && isset($_POST["pass"]))
			processLoginForm();
		else
			displayLoginForm();
	}
	
	function displayConsole() {
		?>
			<ul>
				<li><a href="photo.php" title="Upload and Edit Photos">Add and Edit Photos</a></li>
				<li><a href="videos.php" title="Add and Edit YouTube Videos">Add and Edit YouTube Videos</a></li>
				<li><a href="panel.php?action=logout" title="Logout">Logout</a></li>
			</ul>
		<?php
	}
	
	function processLoginForm() {
		if (QuickAdmin::attemptLogin($_POST["user"], $_POST["pass"])) {
			QuickAdmin::redirect();
		} else {
			echo '<h4>Incorrect credentials.</h4>';
			displayLoginForm();
		}
	}
	
	function displayLoginForm() {
		?>
		<form action="panel.php" method="POST">
			<fieldset>
				<legend>Login</legend>
				
				<label for="user">Username: </label><input type="text" name="user" /><br />
				<label for="pass">Password: </label><input type="password" name="pass" /><br />
				<input type="submit" value="Submit" name="submit" />
			</fieldset>
		</form>
		<?php
	}
	
	if (QuickAdmin::isLoggedIn())
		if ($_GET["action"] == "logout")
			QuickAdmin::logout();
		else
			displayConsole();
	else
		displayOrProcessLoginForm();
	
?>