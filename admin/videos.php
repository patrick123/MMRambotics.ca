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
		
		?>
		  <table>
		    <tr>
		      <th>Playlist</th>
		      <th>Administer</th>
		      <th>Default</th>
		      <th>Delete</th>
		    </tr> 
		<?php
		
		foreach ($playlists as $playlistName => $playlistPath) {
			?>
				<tr>
					<td><?php echo $playlistName; ?></td>
					<td><a href="videos.php?administer=<?php echo $playlistName; ?>" title="Administer">Administer</a></td>
					<td><?php echo (($default == $playlistPath) ? 'Is Default' : '<a href="videos.php?makedefault=' . $playlistName . '">Make Default</a>'); ?></td>
					<td><a href="videos.php?delete=<?php echo $playlistName; ?>">Delete</a></td>
				</tr>
			<?php
		}
		
		?>
		  </table>
		<?php
	}
	
	function displayPlaylistAdministration() {
	
	}
	
	function makeDefaultPlaylist() {
    YouTubeHelper::makeDefaultPlaylist($_GET["makedefault"]);
	}
	
	function deletePlaylist() {
    YouTubeHelper::deletePlaylist($_GET["delete"]);
	}
	
	if (isset($_GET["administer"]))
		displayPlaylistAdministration();
	else if (isset($_GET["makedefault"]))
		makeDefaultPlaylist();
	else if (isset($_GET["delete"]))
		deletePlaylist();
	else
		displayPlaylistOptions();
	
?>
