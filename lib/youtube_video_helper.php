<?php

	/*
	 * @author: Andrew Horsman
	 * @description: Functions to return HTML for YouTube videos from data files stored in db.
	 */
	 
	class YouTubeVideos {
	
		public function getVideos($numberOfVideos = 10, $offsetFromStart = 0) {
			$rawDataFiles = array();
			$videoDataDir = opendir(dirname(__FILE__) . '/db/videos');
			
			for ($counter = 1; $counter < $numberOfVideos; $counter += 10) {
				$dataFile = readdir($videoDataDir);
				if ($dataFile === false)
					break;
					
				$rawDataFiles[] = file_get_contents($dataFile);
			}
		}
		
	}

?>