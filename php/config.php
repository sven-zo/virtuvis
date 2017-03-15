<?php

//Load the usernames, passwords etc. form the settings file
require_once 'settings.php';

//Load database class
require_once 'classes/Database.php';

//Sign in database
$db = new Database(HOST, USERNAME, PASSWORD, DATABASE);

//Load all the other classes
require_once 'classes/Api.php';
require_once 'classes/Weather.php';
require_once 'classes/Wiki.php';
require_once 'classes/User.php';


