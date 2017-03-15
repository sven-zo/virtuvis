<?php
/**
 * This file is created to test the library classes, it will be empty after each successful session
 */

//load configuration
require_once 'config.php';

$user = new User('abctest', $db);
var_dump($user->getId());
var_dump($user->getName());


//Close the database after everything is done
$db->close();


