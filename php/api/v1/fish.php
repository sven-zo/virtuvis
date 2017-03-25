<?php
/**
 * Controller for the api
 *
 * Performs all fish related requests
 */

require_once 'config.php';


//allow access for everyone
header('Access-Control-Allow-Origin: *');

$json = '';

/**
 * LIST fish
 *
 * Lists all the fish of a specific user
 * @required action & user
 * @optional stortby
 *
 * @since v1
 */

if(isset($_GET['action']) && $_GET['action'] === 'LIST' && isset($_GET['user']) && !empty($_GET['user'])){
    $fingerprint = mysqli_real_escape_string($db->getConnection(), $_GET['user']);
    $sort = mysqli_real_escape_string($db->getConnection(), $_GET['sortby']);

    //get the user and required information
    $user = $db->select('id, language_id', 'users', 'fingerprint', $fingerprint);
    $language = $db->selectInnerjoinWhere('languages.shortcode', 'users', 'languages',
        'language_id', 'id', 'fingerprint', $fingerprint);

    // , 'users.fingerprint', $fingerprint
    $userId = $user[0]['id'];
    $userLanguage = $language[0]['shortcode'];

    //Get the fish & species info based on user and sort if specified

        if(isset($_GET['sortby']) && !empty($_GET['sortby'])){

            //Array with all possible sort entries
            $sortEntry = ['recent','recentD','recentA','species', 'speciesD', 'speciesA', 'name', 'nameD', 'nameA', 'favorite'];

            //Array with all right sort values
            $sortColumn = ['date DESC', 'date DESC', 'date ASC', 'species_'.$userLanguage.' DESC', 'species_'.$userLanguage.' DESC',
                'species_'.$userLanguage.' ASC', 'caught_by_user.name DESC', 'caught_by_user.name DESC', 'caught_by_user.name ASC', 'caught_by_user.favorite'];

            //check if the correct value isset
            $sortCheck = false;
            $sortValue = NULL;

            for($i = 0; $i < count($sortEntry); $i++){
                if($sort === $sortEntry[$i]){
                    $sortCheck = true;
                    $sortValue = $sortColumn[$i];
                    break;
                }
            }

            if(!$sortCheck){
                $sortColumn = NULL;
                echo 'Error: incorrect values have been given';
                header('HTTP/1.1 404 Not Found');
                exit;
            }


            $fishList = $db->selectInnerjoinWhere('caught_by_user.id, caught_by_user.user_id AS owner, caught_by_user.name, 
            caught_by_user.weight, caught_by_user.length, caught_by_user.date, caught_by_user.favorite,
            species.name AS species_en, species.name_nl AS species_nl, species.name_scientific 
            AS species_scientific, special',
                'caught_by_user', 'species', 'species_id', 'id', 'user_id', $userId, $sortValue);

        } else {


            $fishList = $db->selectInnerjoinWhere('caught_by_user.id, caught_by_user.user_id AS owner, caught_by_user.name,
            caught_by_user.weight, caught_by_user.length, caught_by_user.date, caught_by_user.favorite,
            species.name AS species_en, species.name_nl AS species_nl, species.name_scientific
            AS species_scientific, special',
            'caught_by_user', 'species', 'species_id', 'id', 'user_id', $userId);
        }

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

    header('Access-Control-Allow-Origin: *');
    header('HTTP/1.1 200 OK');
    header('Content-Type: application/json');


    echo json_encode($json);

} else {

    echo 'Error: make sure you entered all required parameters';
    header('HTTP/1.1 400 Missing Required Parameters');

}

/**
 * UPDATE fish name
 *
 * update the name of an specific fish
 * @required action & fishId & new name
 *
 * @since v1
 */

if(isset($_GET['action']) && $_GET['action'] === 'UPDATE' && isset($_GET['fish']) && !empty($_GET['fish']) && isset($_GET['name'])
&& !empty($_GET['name'])) {

    $fishId = mysqli_real_escape_string($db->getConnection(), $_GET['fish']);
    $name = mysqli_real_escape_string($db->getConnection(), $_GET['name']);
    $fish = new Fish(false,$fishId,$db->getConnection());

    $fish->setName($name);

    header('HTTP/1.1 204 OK empty return');

} else {

    echo 'Error: make sure you entered all required parameters';
    header('HTTP/1.1 400 Missing required parameters');
}


/**
 * UPDATE fish favorite
 *
 * update toggle favorite status of an specific fish
 * @required action & fishId & favorite keyword
 *
 * @since v1
 */

if(isset($_GET['action']) && $_GET['action'] === 'UPDATE' && isset($_GET['fish']) && !empty($_GET['fish']) && isset($_GET['favorite'])) {

    $fishId= mysqli_real_escape_string($db->getConnection(), $_GET['fish']);
    $fish = new Fish(false,$fishId,$db->getConnection());

    $currentStatus = $fish->getFavorite();
    $fish->setFavorite(!$currentStatus);

    header('HTTP/1.1 204 OK empty return');

} else {

    echo 'Error: make sure you entered all required parameters';
    header('HTTP/1.1 400 Missing required parameters');
}


