<?php
function getDbConnection()
{
    $dbHost = getenv('DB_HOST');
    $dbUser = getenv('DB_USER');
    $dbPass = getenv('DB_PASS');
    $dbName = getenv('DB_NAME');
    $connection = pg_connect("host=$dbHost dbname=$dbName user=$dbUser password=$dbPass");
    if (!$connection) {
        echo "Connection failed";
        exit;
    }
    return $connection;
}

