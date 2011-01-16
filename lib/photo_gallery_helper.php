<?php

  /*
   * @author: Andrew Horsman | MMRambotics
   * @description: Photo gallery helper functions.
   */

  class PhotoGalleryHelper {

    /*
	   * Returns a hash from the specificed JSON file in the /db/videos directory. 
	   */
	  public function getDbData($file) {
	    $data = file_get_contents(self::dbFilePath($file));
	    $data = json_decode($data, true);

	    return $data;
	  }	

    /*
     * Returns a full file path relative to videos db.
     */
    public function dbFilePath($file) {
      return (dirname(__FILE__) . '/db/photos/' . $file);
    }

  }

?>
