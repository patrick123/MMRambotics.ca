<?php

  /*
   * @author: Andrew Horsman
   * @description: Returns the contents of a processed page template via a GET
   * parameter in the URL (generally from a URL rewriter).  For instance,
   * http://mmrambotics.ca/about_the_team would send a request to 
   * http://mmrambotics.ca/render.php?page=about_the_team
   */
   
  $page = $_GET["page"];
  if (!isset($page))
    $page = "index";
	
  $page = str_replace("/rambotics/", "", $page);

  require_once(dirname(__FILE__) . '/lib/page.php');
  echo Page::Render($page);

?>
