<?php

  /*
   * @author: Andrew Horsman
   * @description: Returns the contents of a processed page template via a GET
   * parameter in the URL (generally from a URL rewriter).  For instance,
   * http://mmrambotics.ca/about_the_team would send a request to 
   * http://mmrambotics.ca/render.php?page=about_the_team
   */
   
  $page = $GET["page"];
  if (empty($page))
    $page = "index";
    
  require_once(dirname(__FILE__) . '/lib/page.php');
  echo Page::Render($page);

?>
