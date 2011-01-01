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
    $videos = YouTubeHelper::getVideosFromPlaylistRaw($playlistName);
    ?>
      <table>
        <tr>
          <th>Title</th>
          <th>URL</th>
          <th>Description</th>
          <th>Edit</th>
          <th>Delete</th>
        </tr>
    <?php
    
      foreach($videos as $videoId => $video) {
        ?>
          <tr>
            <td><?php echo $video["title"]; ?></td>
            <td><a href="<?php echo $video["url"]; ?>"><?php echo $video["url"]; ?></a></td>
            <td><?php echo $video["description"]; ?></td>
            <td><a href="videos.php?editvideo=<?php echo $videoId; ?>">Edit</a></td>
            <td><a href="videos.php?deletevideo=<?php echo $videoId; ?>">Delete</a></td>
          </tr>
        <?php
      } 
    
    ?>
      </table>
    <?php
	}
	
	function makeDefaultPlaylist() {
    YouTubeHelper::makeDefaultPlaylist($_GET["makedefault"]);
    QuickAdmin::redirect("videos.php");
	}
	
	function deletePlaylist() {
    YouTubeHelper::deletePlaylist($_GET["delete"]);
    QuickAdmin::redirect("videos.php");
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
