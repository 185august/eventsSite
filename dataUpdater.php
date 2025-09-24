<?php
include 'dbConnection.php';


function createNewUser($name, $email, $phone)
{
    $connection = getDbConnection();
    $sql = "INSERT INTO users (name, email, phone) VALUES ($1, $2, $3)";
    $params = array($name, $email, $phone);

    $result = pg_query_params($connection, $sql, $params);
    if (!$result) {
        die("Query failed: " . pg_last_error($connection));
    }
}

function createNewVenue($name, $address, $capacity, $email)
{
    $connection = getDbConnection();
    $sql = "INSERT INTO venues (name, address, capacity, contact_info) VALUES ($1, $2, $3, $4)";
    $params = array($name, $address, $capacity, $email);

    $result = pg_query_params($connection, $sql, $params);
    if (!$result) {
        die("Query failed: " . pg_last_error($connection));
    }
}