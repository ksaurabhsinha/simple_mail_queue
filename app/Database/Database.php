<?php

/**
 * Class Database
 *
 * This class implements the Database Interface and defines the connection and processing of data from database tables
 *
 * @package Database
 * @author  Kumar Saurabh Sinha
 * @version 1.0
 *
 */

namespace Database;


use \PDO;
use \PDOException;
use \Log;


class Database implements DatabaseInterface
{

    private $hostName;
    private $username;
    private $password;
    private $port;
    private $charset;
    private $dbName;
    private $objConn;


    /**
     * initializes the credentials required to setup the database connection
     * @param $credArray
     */
    public function __construct($credArray)
    {

        $this->hostName = $credArray['hostname'];
        $this->username = $credArray['username'];
        $this->password = $credArray['password'];
        $this->charset = $credArray['charset'];
        $this->port = $credArray['port'];
        $this->dbName = $credArray['dbname'];

    }

    /**
     * Create the connection to the Database and returns
     * @return bool|PDO
     */
    public function getConnection()
    {

        try {

            $this->objConn = new PDO('mysql:host=' . $this->hostName . ';dbname=' . $this->dbName . ';charset=' . $this->charset, $this->username, $this->password);
            $this->objConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->objConn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            return $this->objConn;

        } catch (PDOException $ex) {

            Log\Log::writeLog($ex->getMessage(), EXCEPTION_PATH);
            return false;

        }


    }

    /**
     * Defines the way to get the data from the Database tables
     * @param $query
     * @param $queryParams
     *
     * @return bool
     */
    public function getData($query, $queryParams)
    {

        try {

            $stmt = $this->objConn->prepare($query);
            $stmt->execute($queryParams);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $ex) {

            Log\Log::writeLog($ex->getMessage(), EXCEPTION_PATH);
            return false;
        }


    }

    /**
     * Defines the way to update data in the database tables
     * @param $query
     * @param $queryParams
     *
     * @return bool
     */
    public function updateData($query, $queryParams)
    {

        try {
            $this->objConn->beginTransaction();

            $stmt = $this->objConn->prepare($query);

            $stmt->execute($queryParams);

            $this->objConn->commit();

            return $stmt->rowCount();

        } catch (PDOException $ex) {
            $this->objConn->rollBack();
            Log\Log::writeLog($ex->getMessage(), EXCEPTION_PATH);
            return false;
        }

    }

}