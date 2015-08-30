<?php


class FileUtility {


	function __construct() {

	
	}


	public static function getFileName($filePath) {

		$path_parts = pathinfo ( $filePath );
		
		return $path_parts ['filename'];
	
	}


	public static function getFullFileName($filePath) {

		$path_parts = pathinfo ( $filePath );
		
		return $path_parts ['basename'];
	
	}


	public static function getFileExtension($filePath) {

		$path_parts = pathinfo ( $filePath );
		
		return $path_parts ['extension'];
	
	}

}
?>