<?php

	/*
	 * @author: Andrew Horsman | MMRambotics.ca
	 * @description: Administration can edit and add YouTube video entries and playlists.
	 */
	 
	session_start();
	require_once("quick_admin_lib.php");
	require_once("../lib/youtube_video_helper.php");
	
	QuickAdmin::redirectIfNotLoggedIn();

	function displayPlaylistOptions() {
		$playlists = YouTubeHelper::getPlaylistsRaw();
		$default   = YouTubeHelper::getDefaultPlaylistPath(); 
	}

	$playlists = YouTubeHelper::getPlaylistsRaw();
  

?>
