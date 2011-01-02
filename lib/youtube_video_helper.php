<?php

	/*
	 * @author: Andrew Horsman
	 * @description: Functions to return HTML for YouTube videos from data files stored in db.
	 */
	 
	class YouTubeHelper {

	  /*
	   * Returns a hash from the specificed JSON file in the /db/videos directory. 
	   */
	  public function getDbData($file) {
	    $data = file_get_contents(self::dbFilePath($file));
	    $data = json_decode($data, true);

	    return $data;
	  }	
    
    /*
     * Returns a full file path relative to videos db.
     */
    public function dbFilePath($file) {
      return (dirname(__FILE__) . '/db/videos/' . $file);
    }
    
    /*
     * Sets a playlist to the default.
     */
    public function makeDefaultPlaylist($playlistName) {
      $playlists = self::getPlaylistsRaw(false);
      if (array_key_exists($playlistName, $playlists)) {
        $playlists["default"] = $playlistName;
        self::updatePlaylists($playlists);
      }
    }
    
    /*
     * Renames a JSON playlist database to 'delete' it.
     */
    public function deletePlaylist($playlistName) {
      $playlists = self::getPlaylistsRaw(false);
      if (array_key_exists($playlistName, $playlists)) {
        $playlist = self::dbFilePath($playlists[$playlistName]);
        rename($playlist, $playlist . '_trash');
        
        unset($playlists[$playlistName]);
        self::updatePlaylists($playlists);
      } 
    }
    
    /*
     * Edits the playlists JSON database.
     */ 
    public function updatePlaylists($playlists) {
      $db = fopen(self::dbFilePath('playlists.json'), "w");
      if ($db)
        fwrite($db, json_encode($playlists));
    }
    
    /*
     * Updates an individual playlist's JSON database.
     */ 
    public function updateIndividualPlaylist($playlistPath, $newData) {
      $db = fopen($playlistPath, "w");
      if ($db)
        fwrite($db, json_encode($newData));
    } 
	
	  /*
	   * Return a hash of playlist name and filepath.
	   */
		public function getPlaylistsRaw($removeDefault = true) {
		  $playlists = self::getDbData("playlists.json");
      if ($removeDefault) 
        unset($playlists["default"]);
		  
      return $playlists;
		}
		
		/*
		 * Returns the filepath of the default playlist.
		 */
		public function getDefaultPlaylistPath() {
		  $playlists = self::getDbData("playlists.json");
		  return $playlists[$playlists["default"]];
		}
		
		/*
		 * Returns a hash of video data from a playlist.
		 */
		public function getVideosFromPlaylistRaw($playlistFile) {
		  $data = self::getDbData($playlistFile);
		  return $data['data'];
		}
		
    /*
     * Returns a hash of video data based on a video id.
     */
    public function getVideoById($id, $playlist) {
      $playlistPath = self::getPlaylistPath($playlist);
      $data  = self::getVideosFromPlaylistRaw($playlistPath);
      $video = $data[$id];
      
      return $video;
    }
    
		/*
		 * Looks up a playlist file path based on name.
		 */
		public function getPlaylistPath($playlistName) {
		  $data = self::getPlaylistsRaw();
      return $data[$playlistName];
		}
		
    /*
     * Edits a YouTube video via a video ID and playlist. 
     */
    public function editVideo($videoId, $playlist, $title, $url, $description) {
      $newVideo = array(
        "title"       => $title,
        "url"         => $url,
        "description" => $description
      );
      
      $path  = self::getPlaylistPath($playlist);
      $json  = self::getDbData($path);
      $newVideo["date"] = $json["data"][$videoId]["date"];
      $json["data"][$videoId] = $newVideo;
      
      self::updateIndividualPlaylist(self::dbFilePath($path), $json);
    }
    
		/*
		 * Returns HTML for a list of playlists.
		 */
		public function playlistsHTML() {
		  $data = self::getPlaylistsRaw();
		  $html = '<ul id="video-playlists">';
		  
		  foreach ($data as $playlistName => $playlistPath) 
		    $html .= '<li class="playlist-link">' . $playlistName . '</li>';
		  
		  $html .= '</ul>';
		  return $html;
		}
		
		/*
		 * Returns the URL for a YouTube thumbnail based off a YouTube video link.
		 */
		public function youTubeThumbnail($url) {
		  $videoId = explode("=", $url);
		  if (count($videoId) != 2)
		    return false;
		    
		  $videoId = $videoId[1];
		  return 'http://img.youtube.com/vi/' . $videoId . '/default.jpg';
		}
    
    /*
     * Generates a YouTube thumbnail <img> tag based on a YouTube URL.
     */
    public function generateYouTubeThumbnail($url) {
      return '<img width="120" height="90" src="' . self::youTubeThumbnail($url) . '" />';
    }
    
    /*
     * Generated an embedded YouTube video based on a YouTube URL.
     */ 
    public function generateYouTubeEmbed($url) {
      return '<object type="application/x-shockwave-flash" style="width:480px; height:385px;" data="' . $url . '">' .
                '<param name="movie" value="' . $url . '" />' .
		         '</object>';
    }
		
		/*
		 * Returns HTML for a ribbon bar of videos from a playlist.
		 */ 
		public function playlistRibbonBarHTML($playlistFile) {
		  $videos = self::getVideosFromPlaylistRaw($playlistFile);
		  $html   = '<ul id="video-ribbon-bar">';
		  
		  foreach ($videos as $videoId => $video) {
		    $html .= '<li class="video-ribbon-bar-item">' .
		               '<span class="video-ribbon-bar-youtube-url">' . $video['url'] . '</span>' .
		               '<span class="video-ribbon-bar-title">' . $video['title'] . '</span>' .
		               '<span class="video-ribbon-bar-image">' . self::generateYouTubeThumbnail($video['url']) . '</span>' .
		             '</li>';
		  }
		  
		  $html .= '</ul>';
		  return $html;
		}
		
		/* 
		 * Returns HTML for a carousel of videos from a playlist.
		 */
		public function playlistCarouselHTML($playlistFile) {
		  $videos = self::getVideosFromPlaylistRaw($playlistFile);
		  $html   = '<ul id="video-carousel">';
		  
		  $firstVideo = true;
		  foreach ($videos as $videoId => $video) {
		    $class = "video-carousel-item";
		    if ($firstVideo) {
		      $firstVideo = false;
		      $class .= " video-carousel-current-item";
		    }
		    
		    $html .= '<li class="' . $class . '">' .
		               '<span class="video-carousel-youtube">' .
                      self::generateYouTubeEmbed($video['url']) . 
		               '</span><br /><br />' .
		               '<span class="video-carousel-title"><h3 class="video-carousel-header">' . $video['title'] . '</h3></span><br />' .
		               '<span class="video-carousel-description"><p>' . $video['description'] . '</p></span>' .
		             '</li>';
		  }
		  
		  $html .= '</ul>';
		  return $html;
		}
		
	}
	

?>
