<?php

  /*
   * @author: Andrew Horsman | MMRambotics
   * @description: MMRambotics configuration settings.
   */
   
  /* 
   * USAGE NOTE
   * This script contains all of the websites settings, please edit carefully 
   * and make a backup before saving changes.
   *
   * Never edit variable names, variable names are prefixed with a $ (dollar sign).
   * If something is wrapped in quotes, please keep it that way.
   * If something is wrapped in quotes, only edit in between the quotes.
   * If something is not wrapped in quotes, please keep it that way.
   * 
   * To edit a variable, simply change it's value. Please keep in mind the above
   * notes.
   *
   * New variable names should be in snake case.
   */
   
  class Configuration {
    
    public function getValue($configurationKey) {
       $configuration = array(
      
        // General Site
        'base_title' => 'MMRambotics',
        
        // File paths
        'template_filepath_root'  => 'templates',
        'template_file_extension' => '.html.template'
      );  
      
      if (array_key_exists($configurationKey, $configuration)) {
        return $configuration[$configurationKey];
      }
    }
     
  }
  
  /*
   * Why are these not in a human-readable file?  We don't want the trouble
   * of accessing a text file repeatedly for configuration; this is dynamic
   * AND some people (*cough* Sean *cough*) will have a hard time editing it ;)
   */

?>
