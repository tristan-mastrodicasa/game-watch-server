# Project Notes (Game Watch Server)

## Pre-Development Notes

### Technologies Used

### Development Flow

## Documentation Guide Lines

For this project the documentation methods are defined by [PHPDoc](https://www.phpdoc.org/)

### Files

* '@author' Who has touched it

### Classes

* Description
* OP('@extends') If extending

### Functions

* Description
* @param {type} [description]
* @returns {type} [description]

### Adding Handlers

If you want to add a handler you must complete a number of steps

* Add it to accepted categories in the config.php file
* Add a handler with the filename "request".class.php
* The class in the file must follow an uppercase camel case pattern (with the text of "request")
* The class must implement the handler interface in the helper files
* In security support file add the access level and what the request object should be

## Production Notes (Necessary Config)

When deploying project or patches to the production version be sure to change ...

* The ENV variable in index.php to "PROD"
