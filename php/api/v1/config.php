<?php

//Load the usernames, passwords etc. form the settings file
require_once 'settings.php';

//Load database class
require_once 'library/Database.php';

//Sign in database
$db = new Database(HOST, USERNAME, PASSWORD, DATABASE);

//Load all the other library components
require_once 'library/Api.php';
require_once 'library/Weather.php';
require_once 'library/Wiki.php';
require_once 'library/User.php';
require_once 'library/Lake.php';
require_once 'library/Fish.php';

//Custom error handler, so every error will throw a custom ErrorException
set_error_handler(function ($severity, $message, $file, $line) {
    throw new ErrorException($message, $severity, $severity, $file, $line);
});


