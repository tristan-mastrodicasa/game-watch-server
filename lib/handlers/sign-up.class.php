<?php

	/**
	 * Signup handler
	 * @author Tristan Mastrodicasa
	 */

	// Import Helpers //
	// Config already available in index.php
	require_once(LIBRARY_PATH . "/helpers/input-validation.trait.php");
	require_once(LIBRARY_PATH . "/helpers/password.trait.php");

	/**
	 * Handler for the sign up request
	 */
	class SignUp implements Handler {

		use InputValidation, Password;

		private $data;
		private $outObj;
		private $dbAPI;

		public function __construct ($data, $outObj, $dbAPI) {

			$this->data = $data;
			$this->outObj = $outObj;
			$this->dbAPI = $dbAPI;

		}

		public function process () {

			$this->outObj->addError("email", $this->verifyEmail($this->data["email"]));
			$this->outObj->addError("username", $this->verifyUsername($this->data["username"]));
			$this->outObj->addError("password", $this->verifyPassword($this->data["password"]));

			// Check if username or email exist //
			// Check if email is black listed //
			// Check captcha //

			if (!$this->outObj->doesErrorExist()) {

				$this->dbAPI->insert("account_info", [ // Register email
					"email" => $this->data["email"]
				]);

				$rowId = $this->dbAPI->id();

				$this->dbAPI->insert("account_extra_info", [ // Register username
					"uid" => $rowId,
					"username" => $this->data["username"]
				]);

				$this->dbAPI->insert("notification_settings", [ // Create notification settings row
					"uid" => $rowId
				]);

				$salt = $this->generateSalt();

				$this->dbAPI->insert("password_info", [ // Enter password hash and salt
					"uid" => $rowId,
					"phash" => $this->hashPassword($this->data["password"], $salt),
					"psalt" => $salt
				]);

			}

			return $this->outObj->getObject();

		}

	}

?>
