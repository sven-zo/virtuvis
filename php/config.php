<?php

//Load the usernames, passwords etc. form the settings file
require_once 'settings.php';

//Load all the classes
require_once 'classes/Database.php';

//Login Database
$db = new Database(HOST, USERNAME, PASSWORD, DATABASE);
