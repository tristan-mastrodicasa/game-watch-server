<?php

	/**
	 * Holds the output object class
	 * @author Tristan Mastrodicasa
	 */

	/**
	 * OutputObject deals with constructing the response object for all requests
	 */
	class OutputObject {

		private $obj = array(
			"headers" => array(), // Redirect requests, session info, etc
			"content" => array(
				"error" => array(
					"exists" => false,
					"messages" => array()),
				"data" => array()
			)
		);

		public function addError ($key, $errorMessage) {

			if ($errorMessage != null) {

				$this->obj["content"]["error"]["exists"] = true;

				$this->obj["content"]["error"]["messages"][$key] = $errorMessage;

			}

		}

		public function getObject () { return $this->obj; }

		public function doesErrorExist () { return $this->obj["content"]["error"]["exists"]; }

	}


?>
