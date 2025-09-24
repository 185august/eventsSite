<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Events Data</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
$dbResults = include 'dataFetcher.php';
$ticketsResult = $dbResults['tickets'];
$ordersResult = $dbResults['orders'];
$eventsResult = $dbResults['events'];
?>
<div class='event-container'>
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
</div>
<div class='event-container'>
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
</div>
<div class='event-container'>
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
        // The $orders_result variable is populated by the included data_fetcher.php script.
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
