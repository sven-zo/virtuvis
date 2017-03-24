<?php
/**
 * Controller for the api
 *
 * Performs all user related requests
 */

require_once 'config.php';

/**
 * GET user
 *
 * Gets a specific user from the database
 * @required action & user
 *
 * @since v1
 */

if(isset($_GET['action']) && $_GET['action'] === 'GET' && isset($_GET['user']) && !empty($_GET['user'])) {
    $fingerprint = mysqli_real_escape_string($db->getConnection(), $_GET['user']);

    $user = $db->selectAllWhere('users', 'fingerprint', $fingerprint);
    $language = $db->selectInnerjoinWhere('languages.shortcode', 'users', 'languages',
        'language_id', 'id', 'users.fingerprint', $fingerprint);
    $userLanguage = $language[0]['shortcode'];
    $metric = $db->selectInnerjoinWhere('metrics.name', 'users', 'metrics',
        'metric_id', 'id', 'users.fingerprint', $fingerprint);
    $userMetric = $metric[0]['name'];

    $json = [
        'id' => $user['id'],
        'name' => $user['name'],
        'language' => $userLanguage,
        'metric' => $userMetric,
    ];


    header('HTTP/1.1 200 OK');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');

    echo json_encode($json);

} else {

    echo 'Error: make sure you entered all required parameters';
    header('HTTP/1.1 400 Missing parameters');
}




