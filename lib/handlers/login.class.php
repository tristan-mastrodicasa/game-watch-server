<?php

	/**
	 * Login handler
	 * @author Tristan Mastrodicasa
	 */

	class Login implements Handler {

		private $data;
		private $outObj;
		private $dbAPI;

		public function __construct ($data, $outObj, $dbAPI) {

			$this->data = $data;
			$this->outObj = $outObj;
			$this->dbAPI = $dbAPI;

		}

		public function process () {

			return array("out" => "Working :)");

		}

	}

?>
