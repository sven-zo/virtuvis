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
    private $fish;
    private $db;

    /**
     * User constructor.
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

    /**
     * @return array
     */
    public function getAll()
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
        $this->id = $result['id'];

        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        $db = $this->db;

        $result = $db->select('name', 'users', 'fingerprint', $this->fingerprint);
        $this->name = $result['name'];

        return $this->name;
    }

}