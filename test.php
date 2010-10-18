<?php
  
  /* 
   * Testing script for development.
   */
   
  require('lib/template_processing.php');
  
  $test = new TemplateProcessing("test");
  
  //echo "\n" . $test->generate_with_recommended_filters() . "\n";
  //echo "\n" . $test->generate_with_recommended_filters("Testing!") . "\n";

  //echo "\n" . $test->generate_with_recommended_filters(array('prefix' => "Homepage | ")) . "\n";
  //echo "\n" . $test->generate_with_recommended_filters(array('affix' => " | Just That Hardcore")) . "\n";
  echo "\n" . $test->generate_with_recommended_filters(array('prefix' => "Homepage | ", 'affix' => " | Just That Hardcore")) . "\n";
  
?>
