<?php

	/**
	 * Holds the input validation trait
	 * @author Tristan Mastrodicasa
	 */

	trait InputValidation {

		function verifyEmail ($email) {

			$violation = null;

			if (!filter_var($email, FILTER_VALIDATE_EMAIL) || gettype($email) != "string") {

			     $violation = "Not a valid email";

			} else if (strlen($email) > 100) {

				$violation = "Email cannot be longer than 100 characters";

			}

			return $violation;

		}

		function verifyUsername ($username) {

			$violation = null;

			if (gettype($username) != "string") {

				$violation = "Invalid username";

			} else if (strlen($username) > 20) {

				$violation = "Username must be under 20 characters";

			} else if (strlen($username) == 0) {

				$violation = "Username is required";

			}

			return $violation;

		}

		function verifyPassword ($password) {

			$violation = null;

			if (gettype($password) != "string") {

				$violation = "Invalid password";

			} else if (strlen($password) < 5) {

				$violation = "Password must be at least 5 characters";

			}

			return $violation;

		}

	}




?>
