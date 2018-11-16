<?php

	/**
	 * The interface that all handlers must use
	 * @author Tristan Mastrodicasa
	 */

	interface Handler {

		public function __construct ($data, $outObj, $dbAPI); // Must take a data key => value array
		public function process (); // Must output through this function

	}
?>
