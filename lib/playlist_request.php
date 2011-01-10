<?php
  
  /*
   * @author: Andrew Horsman | MMRambotics
   * @description: YouTube playlist content request (AJAX).
   */

  require_once("youtube_video_helper.php");

  if (isset($_POST["name"])) {
    
    $returnData   = array("video" => "", "carousel" => "");
    $playlistPath = YouTubeHelper::getPlaylistPath($_POST["name"]);
    $data         = YouTubeHelper::getVideosFromPlaylistRaw($playlistPath);
    $defaultURL   = YouTubeHelper::getLatestVideoURL($_POST["name"]);

  }

?>
