<?php

  /*
   * @author: Andrew Horsman | MMRambotics
   * @description: HTML template processing.
   */

  require_once(dirname(__FILE__) . '/configuration.php');

  /*
   * Processes a template file with partials and variables.
   */ 
  class TemplateProcessing extends TextHelper {

    private $templateContents = "";
	private $debug            = false;
	
    /*
     * Processes a specified template.
     */ 
    public function __construct($templateName) {
      $this->getTemplateContents($templateName); 
      
      // Process partials until no more are found.
      $numPartials = 1;
      do {
        $numPartials = $this->filterForPartials();
      } while ($numPartials > 0);
      
      $this->filterTemplateVariables();
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
      $templateFilePath = parent::templateFilePath($templateName);
      if (!file_exists($templateFilePath)) 
		if ($debug)
			parent::error("Template does not exist.  $templateFilePath");   
        else
			return false;
			
      $this->templateContents = file_get_contents($templateFilePath);
    }
    
    /*
     * Gets the contents of a partial file via it's partial name (with <<<>>>).
     */
    private function getPartialContents($partialName) {
      $partialFilePath = parent::partialFilePath(parent::getPartialName($partialName));
      if (!file_exists($partialFilePath)) 
        return "";
        
      return file_get_contents($partialFilePath);
    } 

    /*
     * Searches the template contents for partial syntax (<<<partial_name>>>) 
     * and replaces each match with the contents of the partial.
     */
    private function filterForPartials() {
      $partialMatches = $this->getTemplatePartials();
      foreach ($partialMatches as $match) 
        $this->replaceTemplateContents($match, $this->getPartialContents($match));
        
      return count($partialMatches);
    } 
    
    /*
     * Replace the contents of the template with a search and replace parameter.
     */
    private function replaceTemplateContents($search, $replace) {
      $this->templateContents = str_replace($search, $replace, $this->templateContents);
    }
  
    /*
     * Searches the template contents for variables (&&&variable_name&&&) and 
     * replaces each match with the action associated with the variable.
     */  
    private function filterTemplateVariables() {
      foreach ($this->getTemplateVariables() as $match) {
        switch (parent::getVariableName($match)) {
          case "title":
            $this->replaceTemplateContents($match, Configuration::getValue('base_title'));
            break;
          default:
            $this->replaceTemplateContents($match, "Processing error.");
        }
      }
    }
    
    /*
     * Returns an array of all template variable matches.
     */
    private function getTemplateVariables() {
      preg_match_all("/&&&.*?&&&/m", $this->templateContents, $matches);
      return $matches[0];
    }
    
    /*
     * Returns an array of all template partial matches.
     */
    private function getTemplatePartials() {
      preg_match_all("/<<<.*?>>>/m", $this->templateContents, $matches);
      return $matches[0];
    }

  }
  
  /*
   * Various text processing functions that don't rely on an instance state.
   */ 
  class TextHelper {
  
    /*
     * Removes the variable syntax from a matched variable name.
     */
    protected function getVariableName($variable) {
      return str_replace("&&&", '', $variable);
    }
    
    /*
     * Removes the partial syntax from a matched partial name.
     */
    protected function getPartialName($partial) {
      return str_replace(array("<<<", ">>>"), '', $partial);
    } 
    
    /*
     * Returns the full file path of a template name.
     */
    protected function templateFilePath($templateName) {
      return Configuration::getValue('template_filepath_root') . 
             '/' . 
             $templateName . 
             Configuration::getValue('template_file_extension');
    }
    
    /*
     * Returns the full file path of a partial name.
     */
    protected function partialFilePath($partialName) {
      return Configuration::getValue('template_filepath_root') .
             '/' .
             $partialName .
             Configuration::getValue('partial_file_extension');
    }
    
    /*
     * Log an error on the server and kill the page with an error message.
     */
    protected function error($message) {
      error_log($message);
      die($message);
    } 
  
  }
  
?>  

