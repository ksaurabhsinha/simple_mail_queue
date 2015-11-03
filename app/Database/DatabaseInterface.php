<?php

/**
 * Interface DatabaseInterface
 *
 * This is the interface declaration for the Database functionalities
 *
 * @package Database
 * @author  Kumar Saurabh Sinha
 * @version 1.0
 *
 *
 */

/**
 *
 *
 * @package    Mail Queue Implementation
 * @author     Kumar Saurabh Sinha
 * @version    1.0
 * ...
 */

namespace Database;


interface DatabaseInterface {

    /**
     * Should define the connection to the Database
     * @return mixed
     */
    public function getConnection();

    /**
     * Should define the mechanism to get the data from Database
     * @param $query
     * @param $queryParams
     *
     * @return mixed
     */
    public function getData($query, $queryParams);

    /**
     * Should define the mechanism to update data in the database
     * @param $query
     * @param $queryParams
     *
     * @return mixed
     */
    public function updateData($query, $queryParams);


}