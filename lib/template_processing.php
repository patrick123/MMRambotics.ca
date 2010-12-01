<?php

  /*
   * @author: Andrew Horsman | MMRambotics
   * @description: HTML template processing.
   */

  require_once(dirname(__FILE__) . '/configuration.php');

  /*
   * Processes a template file with partials and items from DynamicTextProcessing.
   */ 
  class TemplateProcessing extends DynamicTextProcessing {

    private $templateContents = "";

    public function __construct($templateName) {
      $this->getTemplateContents($templateName); 
      $this->filterForPartials();
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
    
    private function getPartialContents($partialName) {
      $partialFilePath = $this->partialFilePath($partialName);
      if (!file_exists($partialFilePath)) 
        return "";
        
      return file_get_contents($partialFilePath);
    } 

    private function templateFilePath($templateName) {
      return Configuration::getValue('template_filepath_root') . 
             '/' . 
             $templateName . 
             Configuration::getValue('template_file_extension');
    }
    
    private function partialFilePath($partialName) {
      return Configuration::getValue('template_filepath_root') .
             '/' .
             $partialName .
             Configuration::getValue('partial_file_extension');
    }
    
    private function filterForPartials() {
      if (preg_match_all("/<<<.*?>>>/m", $this->templateContents, $matches) !== false) {
        foreach ($matches[0] as $match) {
          $this->templateContents = str_replace($match, $this->getPartialContents($this->getPartialName($match)), $this->templateContents);
        }
      }
    } 
    
    private function getPartialName($partial) {
      return str_replace(array("<<<", ">>>"), '', $partial);
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

