<?php
include_once 'dbConnection.php';


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

function createNewEvent($title, $description, $venue_id, $start_time, $end_time, $organizer_id)
{
    $connection = getDbConnection();
    $sql = "INSERT INTO events (title, description, venue_id, start_time, end_time, organizer_id) VALUES ($1, $2, $3, $4, $5, $6)";
    $params = array($title, $description, $venue_id, $start_time, $end_time, $organizer_id);

    $result = pg_query_params($connection, $sql, $params);
    if (!$result) {
        die("Query failed: " . pg_last_error($connection));
    }
}