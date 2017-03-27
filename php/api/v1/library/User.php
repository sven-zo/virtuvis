<?php
/**
 * User Class
 * This class is written to speed up the process of retrieving user related information from the database.
 */

class User
{
    private $id;
    private $name;
    private $metric;
    private $language;
    private $fingerprint;
    private $rod;
    private $db;

    /**
     * User constructor.
     * Checks if user exists and adds to database if necessary
     * @param $fingerprint
     * @param $db
     * @return User
     */
    public function __construct($fingerprint, $db)
    {

        $this->fingerprint = $fingerprint;
        $this->db = $db;

        return $this;
    }

    public function initUser()
    {

        $exist = $this->db->selectAllWhere('users', 'fingerprint', $this->fingerprint);
        if($exist){

        } else {
            $this->addUser($this->fingerprint);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getAllUsers()
    {
        $db = $this->db;

        $result = $db->selectAll('users');

        return $result;
    }

    /**
     * @return string
     */
    public function getId()
    {
        $db = $this->db;

        $result = $db->select('id', 'users', 'fingerprint', $this->fingerprint);
        $this->id = $result[0]['id'];

        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        $db = $this->db;

        $result = $db->select('name', 'users', 'fingerprint', $this->fingerprint);
        $this->name = $result[0]['name'];

        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getMetric()
    {
        $db = $this->db;

        $result = $db->selectInnerjoinWhere('metrics.name AS name','users','metrics','metric_id','id','fingerprint',$this->fingerprint);
        $this->metric = $result[0]['name'];

        return $this->metric;
    }

    /**
     * @return mixed
     */
    public function getLanguage()
    {
        $db = $this->db;

        $result = $db->selectInnerjoinWhere('languages.shortcode AS shortcode','users','languages','language_id','id','fingerprint',$this->fingerprint);
        $this->language = $result[0]['shortcode'];

        return $this->language;
    }

    /**
     * @return mixed
     */
    public function getFingerprint()
    {
        return $this->fingerprint;
    }

    /**
     * @return mixed
     */
    public function getRod()
    {
        $data = $this->db->selectInnerjoin('rods.fingerprint AS rod','users','rods','rod_id','id','fingerprint',$this->fingerprint);

        if($data){
            $rod = $data[0]['rod'];
            $this->rod = $rod;
        } else {
            $this->rod = false;
        }

        return $this->rod;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $db = $this->db;
        $db->update('users', 'name', $name, 'id', $this->getId());

        $this->name = $name;
    }


    /**
     * @param mixed $metricId
     */
    public function setMetric($metricId)
    {
        $db = $this->db;
        $db->update('users', 'metric_id', $metricId, 'id', $this->getId());

        $this->metric = $metricId;
    }


    /**
     * @param mixed $languageId
     */
    public function setLanguage($languageId)
    {
        $db = $this->db;
        $db->update('users', 'language_id', $languageId, 'id', $this->getId());

        $this->language = $languageId;
    }

    /**
     * addUser method
     * Adds user to the database
     * @param $fingerprint
     */
    private function addUser($fingerprint)
    {
        //Save as later functionality but is a pretty smart possibility
        $db = $this->db;

        $registration = ['name','metric_id','language_id','fingerprint'];
        $values = ['newFisher', 1, 1, $fingerprint];

        $db->insert('users',$registration,$values);

    }
}