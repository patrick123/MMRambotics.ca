<?php
  
  /*
   * @author: Andrew Horsman | MMRambotics
   * @description: Page loader.
   */
   
  require_once(dirname(__FILE__) . '/template_processing.php');
   
  class Page {
    
    public function Render($templateName) {
      $page = new TemplateProcessing($templateName);
	  $page = $page->getProcessedPage();
	  if ($page === false)
		return Render("404");
	
      return $page->getProcessedPage();
    } 
    
  }
  
?>
