<?php

	/**
	 * Entry File to the Game Watch server
	 *
	 * This file will deal with serving page requests, ajax calls
	 * and access permissions
	 *
	 * @author Tristan Mastrodicasa
	 */

    /**
     * Set the headers for the output
     */

     header("Access-Control-Allow-Origin: *");
     header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

    /**
     * Defines what development environment ("DEV" or "PROD")
     * @var string
     */
    $ENV = "DEV";

 	/**
      * Import necessary files
      */

 	require("../config/config.php"); // Production and Development public config

    // Import the correct private files for the different environments //
	if ($ENV == "DEV") require("../config/private.dev.config.php");
    else               require("../config/private.prod.config.php");

    // Import Vendor Files //
    require(VENDOR_PATH . "/autoload.php");

    // Import Helpers //
    require(LIBRARY_PATH . "/helpers/handler.interface.php");
    require(LIBRARY_PATH . "/helpers/file-to-class.function.php");
    require(LIBRARY_PATH . "/helpers/security.class.php");
    require(LIBRARY_PATH . "/helpers/output-object.class.php");

    // Use namespaces //
    use Medoo\Medoo; // Vendor

	/**
     * Establish the handler being requested
     */

    if (!isset($_GET["cat"])) $request = "index";
	else if (in_array($_GET["cat"], $CATEGORIES)) $request = $_GET["cat"];
	else $request = "404";

    // If the request exists //
    if ($request != "404") {

        /**
         * Perform permission based actions
         * E.g check if the user if logged in / restricted handlers
         */

        if (Security::handlerAccess($request)) {

            /**
             * Load the correct handler for the request
             */

            // Check the validity of the request object //
            if (Security::validateRequestData($request, $_POST)) {

                /**
                 * Initialize database connection
                 */

                $database = new Medoo([ // Should all handlers use the same connection??
                    "database_type" => "mysql",
                    "charset" => "utf8",
                    "database_name" => DB_NAME,
                    "server" => DB_SERVER,
                    "username" => DB_USERNAME,
                    "password" => DB_PASSWORD
                ]);

                /**
                 * Initialize output object
                 */

                $outputObj = new OutputObject();

                /**
                 * Initialize handler
                 */

                require(LIBRARY_PATH . "/handlers/" . $request . ".class.php");

                $className = fileToClass($request);
                $handler = new $className($_POST, $outputObj, $database);

                /**
                 * Proccess and send the output
                 */

                echo json_encode($handler->process());

            }

        }

    }

?>
