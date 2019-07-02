<?php

	/**
	 * Holds the security class
	 * @author Tristan Mastrodicasa
	 */

	class HandlerParent {
		
		protected $data;
		protected $dbAPI; // Medoo connection with varying levels of access
		protected $obj = array(
			"meta" => array(), // Redirect requests, session info, etc
			"error" => array(
				"exists" => false,
				"messages" => array()),
			"data" => array()
		);
		
		function __construct ($data, $dbAPI) {

			$this->data = $data;
			$this->dbAPI = $dbAPI;

		}

		protected function addError ($key, $errorMessage) {

			if ($errorMessage != null) {

				$this->obj["error"]["exists"] = true;

				$this->obj["error"]["messages"][$key] = $errorMessage;

			}

		}
		
		protected function addData ($key, $content) {
			
			$this->obj["data"][$key] = $content;
			
		}

		protected function getObject () { return $this->obj; }

		protected function doesErrorExist () { return $this->obj["error"]["exists"]; }
		
	}
	
?>