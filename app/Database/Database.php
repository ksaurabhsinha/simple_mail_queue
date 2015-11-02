<?php

namespace Database;

class Database implements DatabaseInterface {

    private $hostName;
    private $username;
    private $password;
    private $port;
    private $charset;
    private $dbName;
    private $objConn;


    public function __construct($credArray) {

        $this->hostName = $credArray['hostname'];
        $this->username = $credArray['username'];
        $this->password = $credArray['password'];
        $this->charset = $credArray['charset'];
        $this->port = $credArray['port'];
        $this->dbName = $credArray['dbname'];

    }

    public function getConnection() {

        $this->objConn = new PDO('mysql:host=' . $this->hostName . ';dbname= ' . $this->dbName . ' ;charset=' . $this->charset, $this->username, $this->password);
        $this->objConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->objConn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        return $this->objConn;

    }

    public function getData($query, $queryParams) {

        $stmt = $this->objConn->prepare($query);
        $stmt->execute($queryParams);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function updateData($query, $queryParams) {

        try {
            $this->objConn->beginTransaction();

            $stmt = $this->objConn->prepare($query);
            $stmt->execute($queryParams);

            $this->objConn->commit();
        } catch(PDOException $ex) {
            $this->objConn->rollBack();
            //echo $ex->getMessage();
        }

        return $stmt->rowCount();

    }

}