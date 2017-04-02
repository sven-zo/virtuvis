<?php

/**
 * Fish Class
 * This class is written to speed up the process of retrieving fish related information from the database,
 * redering new fish information and combining fish information.
 */

class Fish
{
    private $id;
    private $name;
    private $weight;
    private $length;
    private $species;
    private $speciesNl;
    private $speciesScientific;
    private $habitats;
    private $owner;
    private $date;
    private $favorite;
    private $special;
    private $db;

    public function __construct( $id = false, $db)
    {
        $this->db = $db;

        if(!$id){
            //make fish
            $this->renderSpecies();

        } else {

            $this->id = $id;
        }
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        $db = $this->db;

        $result = $db->select('name', 'caught_by_user', 'id', $this->id);
        $this->name = $result['name'];

        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getWeight()
    {
        $db = $this->db;

        $result = $db->select('weight', 'caught_by_user', 'id', $this->id);
        $this->weight = $result['weight'];

        return $this->weight;
    }

    /**
     * @return mixed
     */
    public function getLength()
    {
        $db = $this->db;

        $result = $db->select('length', 'caught_by_user', 'id', $this->id);
        $this->length = $result['length'];

        return $this->length;
    }

    /**
     * @return mixed
     */
    public function getSpecies()
    {
        $db = $this->db;

        $result = $db->selectInnerjoin('species.name AS name', 'caught_by_user', 'species', 'species_id','id',
            'caught_by_user.id', $this->id);
        $this->species = $result['name'];

        return $this->species;
    }

    /**
     * @return mixed
     */
    public function getSpeciesNl()
    {
        $db = $this->db;

        $result = $db->selectInnerjoin('species.name_nl AS name', 'caught_by_user', 'species', 'species_id','id',
            'caught_by_user.id', $this->id);
        $this->speciesNl = $result['name'];

        return $this->speciesNl;
    }

    /**
     * @return mixed
     */
    public function getSpeciesScientific()
    {
        $db = $this->db;

        $result = $db->selectInnerjoin('species.name_scientific AS name', 'caught_by_user', 'species', 'species_id','id',
            'caught_by_user.id', $this->id);
        $this->speciesScientific = $result['name'];

        return $this->speciesScientific;
    }

    /**
     * @return mixed
     */
    public function getHabitats()
    {
        //Double inner join needed
        $db = $this->db;

        $speciesIdData = $db->select('species_id', 'caught_by_user', 'id', $this->id);
        $speciesId = $speciesIdData['id'];

        $result = $db->selectInnerjoin('habitats.name AS name, habitats.name_nl AS name_nl, habitats.weather AS weather,
         habitats.min_temp AS min_temp, habitats.max_temp AS max_temp', 'species_habitats', 'habitats', 'habitat_id',
            'id', 'species_id', $speciesId);
        $this->habitats = $result;

        return $this->habitats;
    }

    /**
     * @return int (user id)
     */
    public function getOwner()
    {
        $db = $this->db;

        $result = $db->select('user_id', 'caught_by_user', 'id', $this->id);
        $this->owner = $result['user_id'];

        return $this->owner;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {

        $db = $this->db;

        $result = $db->select('date', 'caught_by_user', 'id', $this->id);
        $this->date = $result['date'];

        return $this->date;
    }

    /**
     * @return mixed
     */
    public function getFavorite()
    {
        $db = $this->db;

        $result = $db->select('favorite', 'caught_by_user', 'id', $this->id);
        $this->favorite = $result['favorite'];

        return $this->favorite;
    }

    /**
     * @return mixed
     */
    public function getSpecial()
    {

        $db = $this->db;

        $result = $db->selectInnerjoin('species.special AS special', 'caught_by_user', 'species', 'species_id','id',
            'caught_by_user.id', $this->id);
        $this->special = $result['special'];

        return $this->special;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $db = $this->db;
        $db->update('caught_by_user', 'name', $name, 'id', $this->id);

        $this->name = $name;
    }

    /**
     * @param mixed $favorite
     */
    public function setFavorite($favorite)
    {

        $db = $this->db;
        $db->update('caught_by_user', 'favorite', $favorite, 'id', $this->id);

        $this->favorite = $favorite;
    }

    private function renderSpecies()
    {
        $db = $this->db;
        $species = '';
        $randomFactor = random_int(0,1);

        $weather = new Weather(WEATHER_KEY, WEATHER_LOCATION);

        $condition = $weather->getMainCondition();
        $temperature = intval($weather->getTemperatureC());


        if($randomFactor){

            $result = $db->selectInnerjoin('species_id', 'species_habitats', 'habitats', 'habitat_id', 'id', 'WHERE min_temp < '.$temperature);
            $randomSpecies = random_int(0,count($result) - 1);
            $species = $result[$randomSpecies]['species_id'];

        } else {

            $result = $db->selectInnerjoinWhere('species_id', 'species_habitats', 'habitats', 'habitat_id', 'id', 'weather', $condition);
            $randomSpecies = random_int(0,count($result) - 1);
            $species = $result[$randomSpecies]['species_id'];

        }

        $result = $db->select('name_nl', 'species', 'id', $species);

        $name = $result[0]['name_nl'];
        $weight = $this->randomWeight($species);
        $length = $this->randomLength($species);
        $id = md5(time());
        $columns = ['id', 'user_id', 'species_id', 'name', 'weight', 'length', 'date', 'favorite'];
        $values = [$id, 3, $species, $name, $weight, $length, time(), 0];

        $db->insert('caught_by_user', $columns, $values);

    }

    /**
     * @param $species
     * @return int
     */
    private function randomWeight($species)
    {

        $values = $this->db->selectInnerjoinWhere('max_weight, min_weight', 'species_habitats', 'species', 'species_id',
            'id', 'species_id', $species);

        $weight = random_int($values[0]['min_weight'],$values[0]['max_weight']);

        return $weight;
    }

    private function randomLength($species)
    {
        $values = $this->db->selectInnerjoinWhere('max_length, min_length', 'species_habitats',
            'species', 'species_id', 'id', 'species_id', $species);

        $length = random_int($values[0]['min_length'],$values[0]['max_length']);

        return $length;
    }

}