<?php

	/**
	 * The interface that all handlers must use
	 * @author Tristan Mastrodicasa
	 */

	interface Handler {

		function __construct ($data, $dbAPI); // Must take a data key => value array
		public function process (); // Must output through this function

	}
?>
