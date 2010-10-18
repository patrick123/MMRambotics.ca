<?php
  
  /*
   * @author: Andrew Horsman | Mike Noseworthy | MMRambotics
   * @description: Template processing class.
   */
   
  require(dirname(__FILE__) . '/configuration.php');
  
  /*
   * Template Processing class feeds an HTML template document and processes it
   * to load any dynamic content.  Dynamic content should be referred within the
   * document template as <<<variable>>>.
   */
  class TemplateProcessing extends TextProcessing {
  
    /*
     * Create a new TemplateProcessing object via a template name.
     *
     * @param [String] template_name The template name (without file path or 
     * extension) to process.
     */
    public function __construct($template_name) {
      $this->template_file_path = $this->template_path($template_name);
    }
    
    /*
     * Runs the recommended set of template filters.
     *
     * @param [Mixed] title Can either be a Array or a String, if a non-blank
     * string it will replace the entire title with the string, if an array then
     * the first value will be prefixed to the configuration title and the 
     * second value appended.
     */
    public function generate_with_recommended_filters($title = "") {
      $page = $this->get_raw_template();
      $page = $this->page_title_filter($page, $title);
      
      return $page;
    }
    
    /*
     * Gets the raw template contents for filtering.
     */
    protected function get_raw_template() {
      $template = file_get_contents($this->template_file_path);  
      if (!$template) 
        throw new Exception("Template does not exist.  " . $this->template_file_path);
        
      return $template;
    }
    
    /* 
     * Constructs a template file path from a template name.
     *
     * @param [String] template_name The template name.
     */
    protected function template_path($template_name) {
      global $configuration;
      return '.' . $configuration->template_filepath_root . '/' . $template_name . '.html.template';
    }
    
  }
  
  /* 
   * TextProcessing contains all the functions for converting template variables
   * to text from dynamic sources.
   */
  class TextProcessing {
  
    /* 
     * Replaces <<<title>>> with either the text from the configuration 
     * base_title (default), or with an entirely new title (if passed string) or
     * with a prefix and affix to base_title (if passed array).
     */ 
    public function page_title_filter($text, $title = "") {
      global $configuration;
      
      if ($title === "") {
        $full_title = $configuration->base_title;
      } else if (is_string($title)) {
        $full_title = $title;
      } else if (is_array($title)) {
        $full_title = $configuration->base_title;
        if (array_key_exists('prefix', $title))
          $full_title = $title['prefix'] . $full_title;
          
        if (array_key_exists('affix', $title))
          $full_title = $full_title . $title['affix'];
      } else {
        throw new Exception("Error with title input.");
      }
      
      return str_replace('<<<title>>>', $full_title, $text);
    }
  
  }
  
?>
