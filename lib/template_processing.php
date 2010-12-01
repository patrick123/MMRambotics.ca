<?php

  /*
   * @author: Andrew Horsman | MMRambotics
   * @description: HTML template processing.
   */

  require_once(dirname(__FILE__) . '/configuration.php');

  /*
   * Processes a template file with partials and items from DynamicTextProcessing.
   */ 
  class TemplateProcessing {

    private $templateContents = "";

    public function __construct($templateName) {
      $this->getTemplateContents($templateName); 
    }
    
    public function getProcessedPage() {
      return $this->templateContents;
    }
    
    private function getTemplateContents($templateName) {
      $templateFilePath = $this->templateFilePath($templateName);
      if (!file_exists($templateFilePath))
        $this->error("Template does not exist.  $templateFilePath");   
        
      $this->templateContents = file_get_contents($templateFilePath);
    }

    private function templateFilePath($templateName) {
      return Configuration::getValue('template_filepath_root') . 
             '/' . 
             $templateName . 
             Configuration::getValue('template_file_extension');
    }
    
    private function error($string) {
      error_log($string);
      die($string);
    }

  }

  /*
   * Template variables that need to be parsed and do not come from a static 
   * partial.
   */
  class DynamicTextProcessing {

  }

?>  

