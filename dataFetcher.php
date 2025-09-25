<?php
include 'dbConnection.php';

class dataFetcher
{
    private $connection;

    function __construct()
    {
        $this->connection = getDbConnection();
    }

    function fetchOrders()
    {
        $ordersResult = pg_query($this->connection, "SELECT oi.order_id,
       name,
       title,
       quantity,
       price_at_purchase,
       status,
       ticket_type
    FROM order_items oi
    JOIN orders o
         ON  oi.order_id= o.order_id
        JOIN tickets t
        on oi.ticket_id = t.ticket_id
        JOIN ticket_types tt
        on t.ticket_type_id = tt.ticket_type_id
        JOIN events e
        on t.event_id = e.event_id
        JOIN users u
        on o.user_id = u.user_id
        ");
        if (!$ordersResult) {
            echo "Orders query failed";
            exit;
        }
        return $ordersResult;
    }

    function fetchUsers()
    {
        $usersResult = pg_query($this->connection, "SELECT user_id, name, email, phone FROM users");
        if (!$usersResult) {
            echo "Users query failed";
            exit;
        }
        return $usersResult;
    }

    function fetchEvents()
    {
        $eventsResult = pg_query($this->connection, "SELECT event_id, title, description,  to_char(start_time, 'YYYY-MM-DD HH24:MI') as start_time,
           to_char(end_time, 'YYYY-MM-DD HH24:MI') as end_time, name FROM events
    JOIN venues
        ON events.venue_id = venues.venue_id");
        if (!$eventsResult) {
            echo "Events query failed";
            exit;
        }
        return $eventsResult;
    }

    function fetchTickets()
    {
        $ticketsResult = pg_query($this->connection, "SELECT ticket_id,title,
           to_char(start_time, 'YYYY-MM-DD HH24:MI') as start_time,
           to_char(end_time, 'YYYY-MM-DD HH24:MI') as end_time,
           price,
           available_quantity,
           ticket_type
        FROM tickets t
        JOIN events e
         ON t.event_id = e.event_id
        JOIN ticket_types tt
        on t.ticket_type_id = tt.ticket_type_id;");
        if (!$ticketsResult) {
            echo "Tickets query failed";
            exit;
        }
        return $ticketsResult;
    }

    function fetchVenues()
    {
        $venuesResult = pg_query($this->connection, "SELECT venue_id, name, address, capacity, contact_info FROM venues");
        if (!$venuesResult) {
            echo "Venues query failed";
        }
        return $venuesResult;
    }
}