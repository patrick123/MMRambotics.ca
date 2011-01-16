<?php
  
  /*
   * @author: Andrew Horsman | MMRambotics
   * @description: YouTube playlist content request (AJAX).
   */

  require_once("youtube_video_helper.php");

  if (isset($_POST["name"])) {

    $path = YouTubeHelper::getPlaylistPath($_POST["name"]);
    $data = array(
      "carousel" => YouTubeHelper::playlistCarouselHTML($path),
      "ribbon"   => YouTubeHelper::playlistRibbonBarHTML($path)
    );    

    echo json_encode($data);

  }

?>
