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

    /*
     * Processes a specified template.
     */ 
    public function __construct($templateName) {
      $this->getTemplateContents($templateName); 
      $this->filterForPartials();
    }
    
    /*
     * Returns the current template contnet.
     */
    public function getProcessedPage() {
      return $this->templateContents;
    }
    
    /*
     * Gets the contents of a template file.
     */
    private function getTemplateContents($templateName) {
      $templateFilePath = $this->templateFilePath($templateName);
      if (!file_exists($templateFilePath))
        $this->error("Template does not exist.  $templateFilePath");   
        
      $this->templateContents = file_get_contents($templateFilePath);
    }
    
    /*
     * Gets the contents of a partial file via it's partial name (with <<<>>>).
     */
    private function getPartialContents($partialName) {
      $partialFilePath = $this->partialFilePath($this->getPartialName($partialName));
      if (!file_exists($partialFilePath)) 
        return "";
        
      return file_get_contents($partialFilePath);
    } 

    /*
     * Returns the full file path of a template name.
     */
    private function templateFilePath($templateName) {
      return Configuration::getValue('template_filepath_root') . 
             '/' . 
             $templateName . 
             Configuration::getValue('template_file_extension');
    }
    
    /*
     * Returns the full file path of a partial name.
     */
    private function partialFilePath($partialName) {
      return Configuration::getValue('template_filepath_root') .
             '/' .
             $partialName .
             Configuration::getValue('partial_file_extension');
    }
    
    /*
     * Searches the template contents for partial syntax (<<<partial_name>>>) 
     * and replaces each match with the contents of the partial.
     */
    private function filterForPartials() {
      if (preg_match_all("/<<<.*?>>>/m", $this->templateContents, $matches) !== false) {
        foreach ($matches[0] as $match) 
          $this->replaceTemplateContents($match, $this->getPartialContents($match));
      }
    } 
    
    /*
     * Replace the contents of the template with a search and replace parameter.
     */
    private function replaceTemplateContents($search, $replace) {
      $this->templateContents = str_replace($search, $replace, $this->templateContents);
    }
    
    /*
     * Removes the partial syntax from a matched partial name.
     */
    private function getPartialName($partial) {
      return str_replace(array("<<<", ">>>"), '', $partial);
    } 
    
    /*
     * Log an error on the server and kill the page with an error message.
     */
    private function error($message) {
      error_log($message);
      die($message);
    }

  }

  /*
   * Template variables that need to be parsed and do not come from a static 
   * partial.
   */
  class DynamicTextProcessing {

  }

?>  

