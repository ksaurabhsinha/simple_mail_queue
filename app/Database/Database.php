<?php

namespace Database;

use \PDO;

class Database implements DatabaseInterface
{

    private $hostName;
    private $username;
    private $password;
    private $port;
    private $charset;
    private $dbName;
    private $objConn;


    public function __construct($credArray)
    {

        $this->hostName = $credArray['hostname'];
        $this->username = $credArray['username'];
        $this->password = $credArray['password'];
        $this->charset = $credArray['charset'];
        $this->port = $credArray['port'];
        $this->dbName = $credArray['dbname'];

    }

    public function getConnection()
    {

        try {

            $this->objConn = new PDO('mysql:host=' . $this->hostName . ';dbname=' . $this->dbName . ';charset=' . $this->charset, $this->username, $this->password);
            $this->objConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->objConn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            return $this->objConn;

        } catch (PDOException $ex) {

            //echo $ex->getMessage();
        }


    }

    public function getData($query, $queryParams)
    {

        try {

            $stmt = $this->objConn->prepare($query);
            $stmt->execute($queryParams);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $ex) {

            //echo $ex->getMessage();
        }
        return false;


    }

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
            //echo $ex->getMessage();
        }

        return false;


    }

}