<?php

/**
 * Lake Class
 * This class is written to speed up the process of connecting with the lake.
 */

class Lake
{
    private $id;
    private $fingerprint;
    private $location;
    private $db;

    /**
     * Lake constructor.
     * @param $fingerprint
     * @param $db
     * @return Lake|Bool
     */

    public function __construct($fingerprint, $db)
    {
        $this->fingerprint = $fingerprint;
        $this->db = $db;

        $lakeExists = $db->selectAllWhere('lakes', 'fingerprint', $fingerprint);

        if ($lakeExists){

        } else {

        }
    }

    /**
     * @return string
     */
    public function getId()
    {
        $db = $this->db;

        $result = $db->select('id', 'lakes', 'fingerprint', $this->fingerprint);
        $this->id = $result['id'];

        return $this->id;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        $db = $this->db;

        $result = $db->select('location', 'lakes', 'fingerprint', $this->fingerprint);
        $this->location = $result['location'];

        return $this->location;
    }


    /**
     * @param mixed $location
     */
    public function setLocation($location)
    {
        $db = $this->db;
        $db->update('lakes', 'location', $location, 'id', $this->getId());

        $this->location = $location;
    }


    //Add library that control the visibility of the fish

}