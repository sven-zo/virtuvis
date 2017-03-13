<?php
/**
 * This file is created to test the library classes, it will be empty after each successful session
 */

define('WEATHER_KEY', '4e56ac2d06cb8c8a9538b44566b076ae');

//load configuration
//require_once 'config.php';
require_once 'classes/Api.php';
require_once 'classes/Weather.php';

$weather = new Weather(WEATHER_KEY, 'rotterdam');

print_r($weather->getMainCondition());
