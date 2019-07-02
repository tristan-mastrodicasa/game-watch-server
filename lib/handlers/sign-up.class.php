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
	class SignUp extends HandlerParent implements Handler {

		use InputValidation, Password;

		public function process () {

			$this->addError("username", $this->verifyUsername($this->data["username"]));
			$this->addError("password", $this->verifyPassword($this->data["password"]));
			
			// Check if username or email exist //
			// Check if email is black listed //
			// Check captcha //

			if (!$this->doesErrorExist()) {

				/*$rowId = $this->dbAPI->id();

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
				]);*/
				
				

			}

			return $this->getObject();

		}

	}

?>
