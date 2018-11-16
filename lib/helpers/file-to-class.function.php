<?php

	/**
	 * File to class holds fileToClass function
	 * @author Tristan Mastrodicasa
	 */

	/**
	 * Takes a string like this-is-a-file to ThisIsAFile
	 * @param  String $fileName Unprocessed string (file name)
	 * @return String           Converted string (class name)
	 */
	function fileToClass ($fileName) {

		$words = explode('-', $fileName);
		$className = '';

		foreach ($words as $word) {
			$className .= ucfirst($word);
		}

		return $className;

	}

?>
