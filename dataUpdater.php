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

function createNewTickets($event_id, $ticket_type_id, $price, $available_quantity)
{
    $connection = getDbConnection();
    $sql = "INSERT INTO tickets (event_id, ticket_type_id, price, available_quantity) VALUES ($1, $2, $3, $4)";
    $params = array($event_id, $ticket_type_id, $price, $available_quantity);

    $result = pg_query_params($connection, $sql, $params);
    if (!$result) {
        die("Query failed: " . pg_last_error($connection));
    }
}

function updateTicketQuantity($ticket_id, $new_quantity, $price)
{
    $connection = getDbConnection();
    echo "<script>console.log('Updating ticket_id: $ticket_id with quantity: $new_quantity and price: $price');</script>";
    $sql = "UPDATE tickets SET available_quantity = $1, price =$3  WHERE ticket_id = $2";
    $params = array($new_quantity, $ticket_id, $price);

    $result = pg_query_params($connection, $sql, $params);
    if (!$result) {
        die("Query failed: " . pg_last_error($connection));
    }
}

function createNewOrder($user_id)
{
    $connection = getDbConnection();
    $sql = "INSERT INTO orders (user_id) VALUES ($1) RETURNING order_id";
    $params = array($user_id);

    $result = pg_query_params($connection, $sql, $params);
    if (!$result) {
        die("Query failed: " . pg_last_error($connection));
    }
    $row = pg_fetch_assoc($result);
    return $row['order_id'];
}

function createNewOrderItem($order_id, $ticket_id, $quantity, $price)
{
    $connection = getDbConnection();
    $sql = "INSERT INTO order_items (order_id, ticket_id, quantity, price_at_purchase) VALUES ($1, $2, $3, $4)";
    $params = array($order_id, $ticket_id, $quantity, $price);

    $result = pg_query_params($connection, $sql, $params);
    if (!$result) {
        die("Query failed: " . pg_last_error($connection));
    }
}

function updateOrderToCompleted($order_id)
{
    $connection = getDbConnection();
    $sql = "UPDATE orders SET status = 'Completed' WHERE order_id = $1 RETURNING status";
    $params = array($order_id);

    $result = pg_query_params($connection, $sql, $params);
    if (!$result) {
        die("Query failed: " . pg_last_error($connection));
    }
    $row = pg_fetch_assoc($result);
    return $row['status'];
}

function registerPayment($order_id, $payment_method)
{
    $connection = getDbConnection();
    $sql = "INSERT INTO payments (order_id, payment_method) VALUES ($1, $2)";
    $params = array($order_id, $payment_method);

    $result = pg_query_params($connection, $sql, $params);
    if (!$result) {
        die("Query failed: " . pg_last_error($connection));
    }
}

function createNewEventParticipants($event_id, $user_id, $role_id)
{
    $connection = getDbConnection();
    $sql = "INSERT INTO event_participants (event_id, user_id, role_id) VALUES ($1, $2, $3)";
    $params = array($event_id, $user_id, $role_id);
    $result = pg_query_params($connection, $sql, $params);
    if (!$result) {
        die("Query failed: " . pg_last_error($connection));
    }
}

