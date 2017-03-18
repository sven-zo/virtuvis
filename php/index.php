<?php
/**
 * This file is created to test the library classes, it will be empty after each successful session
 */

//load configuration
require_once 'config.php';

$user = new User('loool', $db);

//Close the database after everything is done
$db->close();


