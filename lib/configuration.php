<?php

  /*
   * @author: Andrew Horsman | Mike Noseworthy | MMRambotics
   * @description: MMRambotics configuration settings.
   */
   
  /* 
   * USAGE NOTE
   * This script contains all of the websites settings, please edit carefully 
   * and make a backup before saving changes.
   *
   * Never edit variable names, each variable is prefixed with a $ (dollar sign)
   * If something is wrapped in quotes, please keep it that way.
   * If something is wrapped in quotes, only edit in between the quotes.
   * If something is not wrapped in quotes, please keep it that way.
   * If something 
   */
   
  class Configuration {

    // General Site
    // Base page title (might be appended or prefixed to).
    public $base_title        = 'MMRambotics' 
    
    // File Paths
    public $template_filepath = '/templates'; 
    
  }
  
  /*
   * Why are these not in a human-readable file?  We don't want the trouble
   * of accessing a text file repeatedly for configuration; this was is dynamic
   * and some people (*cough* Sean *cough*) will have a hard time editing it ;)
   */

?>
