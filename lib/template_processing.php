<?php
  
  /*
   * @author: Andrew Horsman | Mike Noseworthy | MMRambotics
   * @description: Template processing class.
   */
   
  require(dirname(__FILE__) . '/configuration.php');
  
  /*
   * Template Processing class feeds an HTML template document and processes it
   * to load any dynamic content.  Dynamic content should be referred within the
   * document template as {{variable}}.
   */
  class TemplateProcessing {
  
    /*
     * Create a new TemplateProcessing object via a template name.
     *
     * @param [String] template_name The template name (without file path or 
     * extension) to process.
     */
    function __construct($template_name) {
      $template_file_path = $this->template_path($template_name);
    }
    
    /* 
     * Constructs a template file path from a template name.
     *
     * @param [String] template_name The template name.
     */
    protected function template_path($template_name) {
      global $configuration;
      return $configuration->template_filepath . '/' . $template_name . '.html.template';
    }
    
  }
  
?>
