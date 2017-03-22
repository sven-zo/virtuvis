<?php
/**
 * This file is created to test the library library, it will be empty after each successful session
 */

//load configuration
require_once 'config.php';

var_dump($db->selectAll('users'));

//Close the database after everything is done
$db->close();


