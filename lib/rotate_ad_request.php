<?php
  
  /*
   * @author: Andrew Horsman | MMRambotics
   * @description: Gets the image HTML for a random advertisement. (AJAX request).
   */

  require_once("configuration.php");

  $current = "";
  if (isset($_POST["current"]))
    $current = $_POST["current"];

  $data  = json_decode(file_get_contents("db/ads.json"), true);
  $image = "";
  $title = "";
  $link  = "";

  for ($i = 0; $i < 3; ++$i) {
    $index = rand(0, count($data));
    $image = $data[$index]["image"];
    $title = $data[$index]["title"];
    $link  = $data[$index]["link"];
    if ($image != $current)
      break;
  }  

 $image = Configuration::getValue('base_site') . '/images/rotate/' . $image;
 echo '<a href="' . $link . '" title="' . $title . '" target="_blank">';
 echo '<img src="' . $image . '" alt="' . $title . '" title="' . $title . '" class="rotate_ad_image" />';
 echo '</a>';

?>
