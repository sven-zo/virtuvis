<?php
/**
 * This file is created to test the library classes, it will be empty after each successful session
 */

//load configuration
require_once 'config.php';

$user = new User('abctest', $db);
var_dump($user->getId());
var_dump($user->getName());
var_dump($user->getMetric());
var_dump($user->getLanguage());
var_dump($user->listFish());


//Close the database after everything is done
$db->close();


