<?php
namespace virtuvis\library\system;

/**
 * Class Database
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
     */
    public function __construct($host, $user, $password, $database)
    {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->database = $database;

        $db = new \mysqli($host, $user, $password, $database);

        $this->connection = $db;

        return $this;
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

        return $data->fetch_assoc();
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
        $selectQuery = 'SELECT `'.$column.'`'.' FROM `'.$table.'` WHERE `'.$whereColumn.'` = '.$value.';';
        $data = $this->connection->query($selectQuery);

        return $data->fetch_assoc();
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
        $valueChecked = '';

        //Stringify the value if it's a string
        if(is_string($value)){
            $valueChecked .= '\''.$value.'\'';
        } else {
            $valueChecked = $value;
        }

        $updateQuery = 'UPDATE `'.$table.'`'.' SET `'.$column.'` = '.$valueChecked.' WHERE `'.$whereColumn.'` = '.$whereValue.';';
        $this->connection->query($updateQuery);

        return $this;
    }

    /**
     * @param $table
     * @param array $columns
     * @param array $values
     * @return Database
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

        $insertQuery = 'INSERT INTO `'.$table.'` ('.$columnString.') VALUES ('.$valueString.');';
        $this->connection->query($insertQuery);

        return $this;
    }

    public function close()
    {
        $this->connection->close();
    }
}