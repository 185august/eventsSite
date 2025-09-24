<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Events Data</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="main-content-wrapper">
    <?php
    include 'dbConnection.php';

    $connection = getDbConnection();
    $result = pg_query($connection, "SELECT event_id, title, description,  to_char(start_time, 'YYYY-MM-DD HH24:MI') as start_time,
           to_char(end_time, 'YYYY-MM-DD HH24:MI') as end_time, name FROM events
    JOIN venues
        ON events.venue_id = venues.venue_id");
    if (!$result) {
        echo "Query failed";

        exit;
    }
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
            while ($row = pg_fetch_assoc($result)) {
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


    <?php

    $result = pg_query($connection, "SELECT ticket_id,title,
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
    if (!$result) {
        echo "Query failed";
        exit;
    }
    ?>

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
            while ($row = pg_fetch_assoc($result)) {
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
            pg_close($connection);
            ?>
        </table>
    </div>

</div>

</body>
</html>
