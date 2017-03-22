<?php
/**
 * Controller for the api
 * Performs all fish related requests
 */

require_once 'config.php';

$json = 'Error: zorg ervoor dat je alle benodigde parameters hebt ingevuld';

if(isset($_GET['user'])){
    $fingerprint = mysqli_real_escape_string($db->getConnection(), $_GET['user']);

    //get the user and required information
    $user = $db->select('id, language_id', 'users', 'fingerprint', $fingerprint);
    $language = $db->selectInnerjoin('languages.shortcode', 'users', 'languages', 'language_id', 'id');
    $userId = $user[0]['id'];
    $userLanguage = $language[0]['shortcode'];


    //Get the fish & species info based on user
    $fishList = $db->selectInnerjoinWhere('caught_by_user.id, caught_by_user.user_id AS owner, caught_by_user.name, 
    caught_by_user.weight, caught_by_user.length, caught_by_user.date, caught_by_user.favorite,
    species.name AS species_en, species.name_nl AS species_nl, species.name_scientific 
    AS species_scientific, special',
        'caught_by_user', 'species', 'species_id', 'id', 'user_id', $userId);

    //Get the image form the wiki api
    for ($i = 0; $i < count($fishList); $i++){
        $wiki = new Wiki('en');
        $image = $wiki->getImage($fishList[$i]['species_en']);
        $fishList[$i]['image'] = $image;
    }

    //Get description from wiki api
    for ($i = 0; $i < count($fishList); $i++){
        $wiki = new Wiki($userLanguage);
        $text = $wiki->getDescription($fishList[$i]['species_'.$userLanguage]);
        $fishList[$i]['description'] = $text;
    }


    $data = [
        'fish' => $fishList
    ];

    $json = $data;
}

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

echo json_encode($json);