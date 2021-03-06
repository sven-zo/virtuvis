<?php

/**
 * Database Class
 * This class is written to speed up the process of doing simple database queries.
 */

class Database
{
    private $host;
    private $user;
    private $password;
    private $database;
    private $connection;

    /**
     * Database constructor.
     * @param $host
     * @param $user
     * @param $password
     * @param $database
     * @return Database
     */
    public function __construct($host, $user, $password, $database)
    {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->database = $database;

        $db = new \mysqli($host, $user, $password, $database);

        $this->connection = $db;
    }


    /**
     * @return \mysqli
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param $table
     * @return array
     */
    public function selectAll($table)
    {
        $selectAllQuery = 'SELECT * FROM `'.$table.'` ;';
        $data = $this->connection->query($selectAllQuery);

        $result = [];

        while ($row = $data->fetch_assoc()){
            $result[] = $row;
        }

        return $result;
    }

    /**
     * @param $table
     * @param $whereColumn
     * @param $value
     * @return array
     *
     */
    public function selectAllWhere($table, $whereColumn, $value)
    {
        $value = $this->stringifyValue($value);

        $selectAllWhereQuery = 'SELECT * FROM `'.$table.'` WHERE `'.$whereColumn.'` = '.$value;
        $data = $this->connection->query($selectAllWhereQuery);

        $result = [];

        while ($row = $data->fetch_assoc()){
            $result[] = $row;
        }

        return $result;
    }

    /**
     * @param $column
     * @param $table
     * @param $whereColumn
     * @param $value
     * @return array
     */
    public function select($column, $table, $whereColumn, $value)
    {
        $valueChecked = $this->stringifyValue($value);

        $selectQuery = 'SELECT '.$column.' FROM `'.$table.'` WHERE `'.$whereColumn.'` = '.$valueChecked.';';
        $data = $this->connection->query($selectQuery);

        $result = [];

        while ($row = $data->fetch_assoc()){
            $result[] = $row;
        }

        return $result;
    }

    public function selectInnerjoin($column, $table, $joiningTable, $firstTableColumn, $joiningTableColumn, $freeWriting = false)
    {

        $selectInnerQuery = 'SELECT '.$column.' FROM `'.$table.'` INNER JOIN `'.$joiningTable.'` ON '.
            $table.'.'.$firstTableColumn.' = '.$joiningTable.'.'.$joiningTableColumn;

            if($freeWriting){
                $selectInnerQuery .= ' '.$freeWriting;
            }

        $data = $this->connection->query($selectInnerQuery);

        $result = [];

        while ($row = $data->fetch_assoc()){
            $result[] = $row;
        }

        return $result;
    }

    public function selectInnerjoinWhere($column, $table, $joiningTable, $firstTableColumn, $joiningTableColumn, $whereColumn, $whereValue, $sortValue = false)
    {
       $whereValue = $this->stringifyValue($whereValue);

        $selectInnerQuery = 'SELECT '.$column.' FROM `'.$table.'` INNER JOIN `'.$joiningTable.'` ON '.
            $table.'.'.$firstTableColumn.' = '.$joiningTable.'.'.$joiningTableColumn.' WHERE '.
            $whereColumn.' = '.$whereValue;

        if($sortValue){
            $selectInnerQuery .= ' ORDER BY '.$sortValue;
        }

        $data = $this->connection->query($selectInnerQuery);

        $result = [];

        while ($row = $data->fetch_assoc()){
            $result[] = $row;
        }

        return $result;
    }

    /**
     * @param $table
     * @param $column
     * @param $value
     * @param $whereColumn
     * @param $whereValue
     * @return Database
     */
    public function update($table, $column, $value, $whereColumn, $whereValue)
    {
        $valueChecked = $this->stringifyValue($value);
        $whereValue = $this->stringifyValue($whereValue);
        mysqli_real_escape_string($this->getConnection(), $valueChecked);

        $updateQuery = 'UPDATE `'.$table.'`'.' SET `'.$column.'` = '.$valueChecked.' WHERE `'.$whereColumn.'` = '.$whereValue.';';
        $this->connection->query($updateQuery);

        return $this;
    }

    /**
     * @param $table
     * @param array $columns
     * @param array $values
     */
    public function insert($table, $columns = [], $values = [])
    {

        //Stringify the column array so it fits in the query
        $columnString = '';
        for ($i = 0; $i < count($columns); $i++){
            $columnString .= '`'.$columns[$i].'`';
            if(count($columns)-1 !== $i){
                $columnString .= ', ';
            }
        }

        //Stringify the value array so it fits in the query
        $valueString = '';
        for ($i = 0; $i < count($values); $i++){

            if(is_string($values[$i])){
                $valueString .= '\''.$values[$i].'\'';
            } else {
                $valueString .= $values[$i];
            }

            if(count($values)-1 !== $i){
                $valueString .= ', ';
            }
        }

        //Make a real escape string as security measure
        $columnString = mysqli_real_escape_string($this->getConnection(), $columnString);
        //$valueString = mysqli_real_escape_string($this->getConnection(), $valueString); //adds unnecessary slashes

        $insertQuery = 'INSERT INTO `'.$table.'` ('.$columnString.') VALUES ('.$valueString.')';
        $this->connection->query($insertQuery);

    }

    /**
     * Close the database connection
     */
    public function close()
    {
        $this->connection->close();
    }


    /**
     * Make an input of type string a string in database queries
     *
     * @param $value
     * @return string
     */
    private function stringifyValue($value)
    {
        $valueChecked = '';

        if(is_string($value)){
            $valueChecked .= '\''.$value.'\'';
        } else {
            $valueChecked = $value;
        }

        return $valueChecked;
    }
}