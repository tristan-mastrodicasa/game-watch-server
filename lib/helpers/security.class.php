<?php

	/**
	 * Holds the security class
	 * @author Tristan Mastrodicasa
	 */

	class Security {

 		static function validateRequestData ($handler, $requestData) {

 			switch ($handler) {

 				case "sign-up":
 				case "login":
 					if (!isset($requestData["username"])) return false;
 					if (!isset($requestData["password"])) return false;
 					break;

 			}

			return true;

 		}

		static function handlerAccess ($handler) {
			return true;
		}

	}


?>
