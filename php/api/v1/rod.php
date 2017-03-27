<?php
/**
 * Controller for the api
 *
 * Performs all rod related requests
 */

//Load the config
require_once 'config.php';


//allow access for everyone
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');


/**
 * LIST rods
 *
 * Lists all the rods in the game
 * @required action & user
 * @optional stortby
 *
 * @since v1
 */

if(isset($_GET['action']) && $_GET['action'] === 'LIST'){

    $data = $db->selectAll('rods');

    $user = new User('08eb404fe97f2a2bc6c52c9975ebb6d1', $db);
    $user->initUser();

    $json = [
        'rods' => $data,
    ];

    echo json_encode($json);

    header('HTTP/1.1 200 OK');
}