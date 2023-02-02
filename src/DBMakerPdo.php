<?php

/**
 * Created by syscom.
 * User: syscom
 * Date: 17/06/2019
 * Time: 15:50
 */
namespace DBMaker\ODBC;

use PDO;

class DBMakerPdo extends PDO {
    protected $pdo;
    
    /**
     * Get the column listing for a given table.
     *
     * @param  string  $dsn
     * @param  string  $username
     * @param  string  $passwd
     * @param  array   $options
     * @return array
     */
    public function __construct($dsn, $username, $passwd, $options = [])
    {
        if (isset($options['dbidcap']) && $options['dbidcap'] == 1) {
            $options[PDO::ATTR_CASE] = PDO::CASE_LOWER;
        }
        parent::__construct($dsn, $username, $passwd, $options);
        $pdo = new PDO($dsn,$username, $passwd, $options);
        $this->setConnection($pdo);     
    }
    
    /**
     *
     * @param  string  $statement
     * @param  array  $driver_options
     * @return Dbmaker\Odbc\DBMakerPdo
     */        
    public function prepare($statement,$driver_options = null)
    {
        return parent::prepare($statement); 
    }
    
      /**
     * @return mixed
     */
    public function getConnection()
    {
        return $this->pdo;
    }

    /**
     * @param mixed $connection
     * @return void
     */
    public function setConnection($pdo)
    {
        $this->pdo = $pdo;
    }
}