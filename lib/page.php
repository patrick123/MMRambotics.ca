<?php
  
  /*
   * @author: Andrew Horsman | MMRambotics
   * @description: Page loader.
   */
   
  require_once(dirname(__FILE__) . '/template_processing.php');
   
  class Page {
    
    public function Render($templateName) {
      $page = new TemplateProcessing($templateName);
      return $page->getProcessedPage();
    } 
    
  }
  
?>
