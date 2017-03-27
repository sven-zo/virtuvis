<?php
/**
 * Controller for the api
 *
 * Performs all user related requests
 */

//Load the config
require_once 'config.php';


//allow access for everyone
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

/**
 * GET user
 *
 * Gets a specific user from the database
 * If the user doesn't exist (s)he will be added to the database
 * @required action & user
 *
 * @since v1
 */

if(isset($_GET['action']) && $_GET['action'] === 'GET' && isset($_GET['user']) && !empty($_GET['user'])) {
    $fingerprint = mysqli_real_escape_string($db->getConnection(), $_GET['user']);

    $user = new User($fingerprint, $db);
    $user->initUser();

   $json = [
        'id' => $user->getId(),
        'name' => $user->getName(),
        'language' => $user->getLanguage(),
        'metric' => $user->getMetric(),
        'rod' => $user->getRod()
   ];


    header('HTTP/1.1 200 OK');

    echo json_encode($json);
}

//else {
//
//    echo 'Error: make sure you entered all required parameters';
//    header('HTTP/1.1 400 Missing required parameters');
//}

/**
 * UPDATE username
 *
 * Change the username from a specific user from the database
 * @required action & user & new username
 *
 * @since v1
 */

if(isset($_GET['action']) && $_GET['action'] === 'UPDATE' && isset($_GET['user']) && !empty($_GET['user']) && isset($_GET['username'])
    && !empty($_GET['username'])) {
    $fingerprint = mysqli_real_escape_string($db->getConnection(), $_GET['user']);
    $username = mysqli_real_escape_string($db->getConnection(), $_GET['username']);

    $user = new User($fingerprint, $db->getConnection());
    $user->setName($username);

    header('HTTP/1.1 200 OK empty return');


}

//else {
//
//    echo 'Error: make sure you entered all required parameters';
//    header('HTTP/1.1 400 Missing required parameters');
//}

/**
 * UPDATE user language
 *
 * Change the user language from a specific user from the database
 * @required action & user & new language
 *
 * @since v1
 */
if(isset($_GET['action']) && $_GET['action'] === 'UPDATE' && isset($_GET['user']) && !empty($_GET['user']) && isset($_GET['language'])
    && !empty($_GET['language'])) {

    $fingerprint = mysqli_real_escape_string($db->getConnection(), $_GET['user']);
    $language = mysqli_real_escape_string($db->getConnection(), $_GET['language']);
    $languageList = $db->selectAll('languages');

    $languageCheck = false;
    $languageId = NULL;

    for($i = 0; $i < count($languageList); $i++){
        if($languageList[$i]['shortcode'] === $language){
            $languageCheck = true;
            $languageId = $languageList[$i]['id'];
            break;
        }
    }

    if(!$languageCheck){
        echo 'Error: incorrect values have been given';
        header('HTTP/1.1 404 Not Found');
        exit;
    }

    $user = new User($fingerprint, $db);
    $user->setLanguage($languageId);

    header('HTTP/1.1 200 OK empty return');

}

//else {
//
//    echo 'Error: make sure you entered all required parameters';
//    header('HTTP/1.1 400 Missing required parameters');
//}


/**
 * UPDATE user metric
 *
 * Change the user metric from a specific user from the database
 * @required action & user & new metric
 *
 * @since v1
 */

if(isset($_GET['action']) && $_GET['action'] === 'UPDATE' && isset($_GET['user']) && !empty($_GET['user']) && isset($_GET['metric'])
    && !empty($_GET['metric'])) {

    $fingerprint = mysqli_real_escape_string($db->getConnection(), $_GET['user']);
    $metric = mysqli_real_escape_string($db->getConnection(), $_GET['metric']);
    $metricList = $db->selectAll('metrics');

    $metricCheck = false;
    $metricId = NULL;

    for($i = 0; $i < count($metricList); $i++){
        if($metricList[$i]['name'] === $metric){
            $metricCheck = true;
            $metricId = $metricList[$i]['id'];
            break;
        }
    }

    if(!$metricCheck){
        echo 'Error: incorrect values have been given';
        header('HTTP/1.1 404 Not Found');
        exit;
    }

    $user = new User($fingerprint, $db);
    $user->setMetric($metricId);

    header('HTTP/1.1 200 OK empty return');

}

//else {
//
//    echo 'Error: make sure you entered all required parameters';
//    header('HTTP/1.1 400 Missing required parameters');
//}