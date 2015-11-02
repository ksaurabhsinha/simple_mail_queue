<?php

namespace Database;

interface DatabaseInterface {

    public function getConnection();

    public function getData($query, $queryParams);

    public function updateData($query, $queryParams);


}