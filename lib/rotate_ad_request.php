<?php
  
  /*
   * @author: Andrew Horsman | MMRambotics
   * @description: Gets the image HTML for a random advertisement. (AJAX request).
   */

  require_once("configuration.php");

  $current = "";
  if (isset($_POST["current"]))
    $current = $_POST["current"];

  $data  = json_decode(file_get_contents("db/ads.json"));
  $image = "";
  $title = "";
  $link  = "";

  for ($i = 0; $i < 3; ++$i) {
    $index = rand(0, count($data);
    $image = $data[$index]["image"];
    if ($image != $current)
      break;
  }  

 $image = Configuration::getValue('base_site') . '/images/rotate/' . $image;
 echo '<a href="' . $link . '" title="' . $title . '">';
 echo '<img src="' . $image . '" alt="' . $title . '" title="' . $title = '" />';
 echo '</a>';

?>
