<?php

  /*
   * @author: Andrew Horsman
   * @description: Send mail via contact form.
   */
   
  require_once(dirname(__FILE__) . '/configuration.php');
   
  function checkRequiredFields(&$mailForm) {
    $requiredFields = array('email' => 'email address', 'full-name' => 'name', 'subject' => 'subject line', 'message' => 'message body');
    $errorMessage   = "";
    foreach ($requiredFields as $field => $friendlyName) {
      if (!array_key_exists($field, $mailForm))
        $errorMessage .= "Error, $friendlyName required.<br />";
    }
    
    if (filter_var($mailForm['email'], FILTER_VALIDATE_EMAIL))
      $errorMessage .= "Error, invalid email address.<br />";
    
    if ($errorMessage != "")
      die($errorMessage);
  }
  
  function structureSubjectLine(&$mailForm) {
    $subjectLine = '[' . Configuration::getValue('subject_line_base') . '] ';
  
    if (!empty($mailForm['category']))
      $subjectLine .= '[' . $mailForm['category'] . '] ';
      
    $subjectLine .= $mailForm['subject'];
    return $subjectLine;
  } 
  
  function structureFullMessage(&$mailForm) {
    $message  = 'New email submitted from MMRambotics contact form.\n';
    $message .= 'Email Address: ' . $mailForm['email'] . '\n';
    $message .= 'Subject:       ' . $mailForm['subject'] . '\n';
    $message .= 'Full Name:     ' . $mailForm['full-name'] . '\n';
    $message .= 'Category:      ' . $mailForm['category'] . '\n';
    
    if (!empty($mailForm['title']))
      $message .= 'Title:         ' . $mailForm['title'] . '\n';
    
    if (!empty($mailForm['phone-number']))
      $message .= 'Phone:         ' . $mailForm['phone-number'] . '\n';
    
    $message .= '\n\n\n';
    $message .= $mailForm['message'];
    $message .= '\n\n\n';
    
    return $message;
  }
   
  if (array_key_exists("contact", $_POST)) {
   
    $mailForm = json_decode($_POST["contact"]);
    checkRequiredFields($mailForm);
    
    $recipient = Configuration::getValue('contact_us_recipient');
    $from      = $mailForm['full-name'] . ' <' . $mailForm['email'] . '>';
    $subject   = structureSubjectLine($mailForm);
    $message   = structureFullMessage($mailForm);
    $headers   = 'From: $from\r\nReply-To: $from';
    
    if (mail($recipient, $subject, $message, $headers))
      die('Mail successfully sent!');
    else
      die('An error occurred while processing your form.');
  
  }
  
  
?>
