<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Events Data</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
require_once 'dataFetcher.php';
$dataFetcher = new dataFetcher();

$venuesResult = $dataFetcher->fetchVenues();
$usersResult = $dataFetcher->fetchUsers();
$ticketsResult = $dataFetcher->fetchTickets();
$ordersResult = $dataFetcher->fetchOrders();
$eventsResult = $dataFetcher->fetchEvents();
?>


<div class='event-container'>
    <h1>Users</h1>
    <table class="event-table">
        <tr>
            <th>User name</th>
            <th>Email</th>
            <th>Phone</th>
        </tr>
        <?php
        while ($row = pg_fetch_assoc($usersResult)) {
            echo "
                <tr id='{$row['user_id']}' >
                <td>{$row['name']}</td>
                <td>{$row['email']}</td>
                <td>{$row['phone']}</td>
                </tr>
                ";
        }
        ?>
    </table>
    <a href="registerNewUserForm.php" class="button-link">Create a new user</a>

    <h1>Venus</h1>
    <table class="event-table">
        <tr>
            <th>Venue name</th>
            <th>Address</th>
            <th>Capacity</th>
            <th>Contact info</th>
        </tr>
        <?php
        while ($row = pg_fetch_assoc($venuesResult)) {
            echo "
                <tr id='{$row['venue_id']}' >
                <td>{$row['name']}</td>
                <td>{$row['address']}</td>
                <td>{$row['capacity']}</td>
                <td>{$row['contact_info']}</td>
                </tr>
                ";
        }
        ?>
    </table>
    <a href="registerNewVenueForm.php" class="button-link">Create a new Venue</a>


    <h1>Events</h1>
    <table class="event-table">
        <tr>
            <th>Event Name</th>
            <th>Event Description</th>
            <th>Start time</th>
            <th>End time</th>
            <th>Venue</th>
        </tr>
        <?php
        while ($row = pg_fetch_assoc($eventsResult)) {
            echo "
                <tr id='{$row['event_id']}' >
                <td>{$row['title']}</td>
                <td>{$row['description']}</td>
                <td>{$row['start_time']}</td>
                <td>{$row['end_time']}</td>
                <td>{$row['name']}</td>
                </tr>
                ";
        }
        ?>
    </table>


    <h1>Tickets</h1>
    <table class="event-table">
        <tr>
            <th>Event Name</th>
            <th>Start time</th>
            <th>End time</th>
            <th>Ticket Type</th>
            <th>Ticket price</th>
            <th>Ticket availability</th>
        </tr>
        <?php

        while ($row = pg_fetch_assoc($ticketsResult)) {
            echo "
                <tr id='{$row['ticket_id']}' >
                <td>{$row['title']}</td>
                <td>{$row['start_time']}</td>
                <td>{$row['end_time']}</td>
                <td>{$row['ticket_type']}</td>
                <td>{$row['price']}</td>
                <td>{$row['available_quantity']}</td>
                </tr>
                ";
        }
        ?>
    </table>


    <h1>Orders</h1>
    <table class="event-table">
        <tr>
            <th>Order number</th>
            <th>User Name</th>
            <th>Event Name</th>
            <th>Quantity</th>
            <th>Ticket price</th>
            <th>Ticket Type</th>
            <th>Status</th>
        </tr>
        <?php
        while ($row = pg_fetch_assoc($ordersResult)) {
            echo "
                <tr id='{$row['order_id']}' >
                <td>{$row['order_id']}</td>
                <td>{$row['name']}</td>
                <td>{$row['title']}</td>
                <td>{$row['quantity']}</td>
                <td>{$row['price_at_purchase']}</td>
                <td>{$row['ticket_type']}</td>
                <td>{$row['status']}</td>
                </tr>
                ";
        }
        ?>
    </table>
</div>
</body>
</html>
