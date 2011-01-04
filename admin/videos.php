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
		  <table border="1">
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
      
      <hr />
      <a href="videos.php?addplaylist=add" title="Add Playlist">Add a Playlist</a>
		<?php
	}
	
	function displayPlaylistAdministration() {
    $path   = YouTubeHelper::getPlaylistPath($_GET["administer"]);
    $videos = YouTubeHelper::getVideosFromPlaylistRaw($path);
    ?>
      <table border="1">
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
            <td><a href="videos.php?editvideo=<?php echo $videoId; ?>&playlist=<?php echo $_GET["administer"]; ?>">Edit</a></td>
            <td><a href="videos.php?deletevideo=<?php echo $videoId; ?>&playlist=<?php echo $_GET["administer"]; ?>">Delete</a></td>
          </tr>
        <?php
      } 
    
    ?>
      </table>
      
      <hr />
      <a href="videos.php?addvideo=add?playlist=<?php echo $_GET["administer"]; ?>" title="Add Video">Add a Video</a>
    <?php
	}
  
  function editSingleVideo() {
    if (isset($_GET["videoId"]) && isset($_GET["playlist"])) {
      YouTubeHelper::editVideo($_GET["videoId"], $_GET["playlist"], $_GET["title"], $_GET["url"], $_GET["description"]);
    }

    QuickAdmin::redirect("videos.php?administer=" . $_GET["playlist"]);
  }
  
  function displayEditVideoForm() {
    $video = YouTubeHelper::getVideoById($_GET["editvideo"], $_GET["playlist"]);
    ?>
      <form method="GET" action="videos.php">
        <input type="hidden" name="videoEdit" value="1" />
        <input type="hidden" name="videoId" value="<?php echo $_GET["editvideo"]; ?>" />
        <input type="hidden" name="playlist" value="<?php echo $_GET["playlist"]; ?>" />
        
        <label for="title">Title: </label><br />
        <input type="text" name="title" value="<?php echo $video['title']; ?>" style="width:90%;" />
        
        <br /></br />
        
        <label for="url">URL: </label><br />
        <input type="text" name="url" value="<?php echo $video['url']; ?>" style="width:90%;" />
        
        <br /><br />
        
        <label for="description">Description: </label><br />
        <input type="text" name="description" value="<?php echo $video['description']; ?>" style="width:90%;" />
        
        <br />
        <input type="submit" value="Submit" />
      </form>
    <?php
  }
  
  function displayAddVideoForm() {
    ?>
      <form method="GET" action="videos.php">
        <input type="hidden" name="videoAdd" value="1" />
        <input type="hidden" name="playlist" value="<?php echo $_GET["playlist"]; ?>" />
        
        <label for="title">Title: </label><br />
        <input type="text" name="title" />
        
        <br /><br />
        
        <label for="url">URL: </label><br />
        <input type="text" name="url" />
        
        <br /><br />
        
        <label for="description">Description: </label><br />
        <input type="text" name="description" />
        
        <br />
        <input type="submit" value="Submit" />
      </form>
    <?php
  }
  
  function displayAddPlaylistForm() {
    ?>
      <form method="GET" action="videos.php">
        <input type="hidden" name="playlistAdd" value="1" />
        
        <input for="name">Playlist Name: </label><br />
        <input type="text" name="name" />
        
        <br /><br />
        
        <input type="checkbox" name="isDefault" value="true">&nbsp;<label for="isDefault">Is Default?</label><br />
        
        <input type="submit" value="Submit" />
      </form>
    <?php
  }
  
  function deleteSingleVideo() {
    YouTubeHelper::deleteVideo($_GET["deletevideo"], $_GET["playlist"]);
    QuickAdmin::redirect("videos.php?administer=" . $_GET["playlist"]);
  }
	
	function makeDefaultPlaylist() {
    YouTubeHelper::makeDefaultPlaylist($_GET["makedefault"]);
    QuickAdmin::redirect("videos.php");
	}
	
	function deletePlaylist() {
    YouTubeHelper::deletePlaylist($_GET["delete"]);
    QuickAdmin::redirect("videos.php");
	}
	
	function addPlaylist() {
	  YouTubeHelper::addPlaylist($_GET["name"]);
	  if ($_GET["isDefault"] == "true") 
	    YouTubeHelper::makeDefaultPlaylist($_GET["name"]);
	    
	  QuickAdmin::redirect("videos.php");
	}
	
	function addVideo() {
	
	}
	
	if (isset($_GET["administer"]))
		displayPlaylistAdministration();
	else if (isset($_GET["makedefault"]))
		makeDefaultPlaylist();
	else if (isset($_GET["delete"]))
		deletePlaylist();
  else if (isset($_GET["editvideo"]))
    displayEditVideoForm();
  else if (isset($_GET["deletevideo"]))
    deleteSingleVideo();
  else if (isset($_GET["videoEdit"]))
    editSingleVideo();
  else if (isset($_GET["videoAdd"]))
    addVideo();
  else if (isset($_GET["playlistAdd"]))
    addPlaylist();
  else if (isset($_GET["addvideo"]))
    displayAddVideoForm();
  else if (isset($_GET["addplaylist"]))
    displayAddPlaylistForm();
	else
		displayPlaylistOptions();
	
?>
