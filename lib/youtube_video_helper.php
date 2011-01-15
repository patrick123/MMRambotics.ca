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
     * Adds a playlist to the JSON database.
     */
    public function addPlaylist($playlistName) {
      $playlists = self::getPlaylistsRaw(false);
      $filePath  = self::playlistNameToFile($playlistName);
      $db        = fopen(self::dbFilePath($filePath), "w");
      fwrite($db, '{"data":{}}');
      fclose($db);
      
      $playlists[$playlistName] = $filePath;
      self::updatePlaylists($playlists);
    }
    
    /*
     * Adds a new YouTube video to an individual playlist's JSON database.
     */
    public function addVideo($url, $title, $description, $playlist) {
      $newVideo = array(
        "url"         => $url,
        "title"       => $title,
        "description" => $description,
        "date"        => date("U")
      );
      
      $videoId = uniqid();
      $path    = self::getPlaylistPath($playlist);
      $json    = self::getDbData($path);
      $json["data"][$videoId] = $newVideo;
      
      self::updateIndividualPlaylist(self::dbFilePath($path), $json);
    }
    
    /*
     * Converts a playlist name to a file path (to be used to write operations only).
     */ 
    public function playlistNameToFile($name) {
      return substr(uniqid(urlencode($name)), 0, 40) . ".json";
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
     * Deletes a video from a playlist via it's id.
     */ 
    public function deleteVideo($videoId, $playlist) {
      $path = self::getPlaylistPath($playlist);
      $json = self::getDbData($path);
      unset($json["data"][$videoId]);
      
      self::updateIndividualPlaylist(self::dbFilePath($path), $json);
    }
    
		/*
		 * Returns HTML for a list of playlists.
		 */
		public function playlistsHTML() {
		  $data  = self::getPlaylistsRaw();
		  $html  = '<ul id="video-playlists">';
		  
		  foreach ($data as $playlistName => $playlistPath) {
		    $thumb = self::generateYouTubeThumbnail(self::getLatestVideoURL($playlistName));
		    $html .= '<li class="playlist-link">' . $playlistName . '<span class="playlist-name">' . $playlistName . '</span><span class="playlist-thumbnail">' . $thumb . '</span></li>';
		  }
		  
		  $html .= '</ul>';
		  return $html;
		}
		
		/*
		 * Predicate function for comparing video dates.
		 */
		public function dateCompare($a, $b) {
		  return strcmp($a['date'], $b['date']);
		}
		
		/*
		 * Gets the URL of the latest YouTube video in a playlist.
		 */
		public function getLatestVideoURL($playlistName) {
      $videos = self::getVideosChronological(self::getPlaylistPath($playlistName));
		  return $videos[0]["url"];
    }

    /*
     * Gets an array of videos in chronological order.
		 */
    public function getVideosChronological($playlistPath) {
      $json   = self::getDbData($playlistPath);
      $json   = $json["data"];
      $videos = array();

      foreach ($json as $videoId => $video) 
        $videos[] = $video;

      usort($videos, array(self, "dateCompare"));
      return $videos;
    }

		/*
		 * Returns the URL for a YouTube thumbnail based off a YouTube video link.
		 */
		public function youTubeThumbnail($url) {
      $videoId = explode("/v/", $url);
		  if (count($videoId) != 2)
		    return false;
		    
		  $videoId = $videoId[1];
		  return 'http://img.youtube.com/vi/' . $videoId . '/default.jpg';
		}
    
    /*
     * Generates a YouTube thumbnail <img> tag based on a YouTube URL.
     */
    public function generateYouTubeThumbnail($url) {
      $finalURL = self::youTubeThumbnail($url);
      if (empty($finalURL))
        return '';
        
      return '<img width="120" height="90" src="' . $finalURL . '" />';
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
		  $videos = self::getVideosChronological($playlistFile);
		  $html   = '<ul id="video-ribbon-bar">';

      $class = 'video-ribbon-bar-item current';
		  foreach ($videos as $videoId => $video) {
		    $html .= '<li class="' . $class . '">' .
		               '<span class="video-ribbon-bar-youtube-url">' . $video['url'] . '</span>' .
		               '<span class="video-ribbon-bar-title">' . $video['title'] . '</span>' .
		               '<span class="video-ribbon-bar-image">' . self::generateYouTubeThumbnail($video['url']) . '</span>' .
                   '</li>';
        $class = 'video-ribbon-bar-item';
		  }
		  
		  $html .= '</ul>';
		  return $html;
		}
		
		/* 
		 * Returns HTML for a carousel of videos from a playlist.
		 */
		public function playlistCarouselHTML($playlistFile) {
		  $videos = self::getVideosChronological($playlistFile);
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
