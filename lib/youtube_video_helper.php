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
	    echo dirname(__FILE__) . '/db/videos/' . $file;
	    $data = file_get_contents(dirname(__FILE__) . '/db/videos/' . $file);
	    $data = json_decode($data, true);

	    return $data;
	  }	
	
	  /*
	   * Return a hash of playlist name and filepath.
	   */
		public function getPlaylistsRaw() {
		  $playlists = self::getDbData("playlists.json");
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
		 * Looks up a playlist file path based on name.
		 */
		public function getPlaylistPath($playlistName) {
		  $data = self::getPlaylistsRaw();
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
		public function youtubeThumbnail($url) {
		  $videoId = explode("=", $url);
		  if (count($videoId) != 2)
		    return false;
		    
		  $videoId = $videoId[1];
		  return 'http://img.youtube.com/vi/' . $videoId . '/default.jpg';
		}
		
		/*
		 * Returns HTML for a ribbon bar of videos from a playlist.
		 */ 
		public function playlistRibbonBarHTML($playlistFile) {
		  $videos = self::getVideosFromPlaylistRaw($playlistFile);
		  $html   = '<ul id="video-ribbon-bar">';
		  
		  foreach ($videos as $video) {
		    $html .= '<li class="video-ribbon-bar-item">' .
		               '<span class="video-ribbon-bar-youtube-url">' . $video['url'] . '</span>' .
		               '<span class="video-ribbon-bar-title">' . $video['title'] . '</span>' .
		               '<span class="video-ribbon-bar-image"><img width="120" height="90" src="' . self::youtubeThumbnail($video['url']) . '" /></span>' .
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
		  foreach ($videos as $video) {
		    $class = "video-carousel-item";
		    if ($firstVideo) {
		      $firstVideo = false;
		      $class .= " video-carousel-current-item";
		    }
		    
		    $html .= '<li class="' . $class . '">' .
		               '<span class="video-carousel-youtube">' .
		                  '<object type="application/x-shockwave-flash" style="width:480px; height:385px;" data="' . $video['url'] . '">'.
		                    '<param name="movie" value="' . $video['url'] . '" />' .
		                  '</object>' .
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
