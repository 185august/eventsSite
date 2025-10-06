<!<!doctype html>
    <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Register new event</title>
            <link rel="stylesheet" href="style.css">
        </head>

        <body>
            <div class="data-container">
                <a href="index.php" class="button-link">Go back</a>
                <?php
                include_once 'dataFetcher.php';
                $dataFetcher = new DataFetcher();
                $venusResult = $dataFetcher->fetchVenues();
                $usersResult = $dataFetcher->fetchUsers();
                ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    Event name: <label>
                        <input name="eventName" required type="text">
                    </label>
                    <br>
                    Event description: <label>
                        <input name="description" required type="text">
                    </label>
                    <br>
                    Start Time: <label>
                        <input name="startTime" required type="datetime-local">
                    </label>
                    <br>
                    End Time: <label>
                        <input name="endTime" required type="datetime-local">
                    </label>
                    <br>
                    Venue Name: <label>
                        <select name="venue">
                            <?php

                            while ($row = pg_fetch_assoc($venusResult)) {
                                echo "<option value='{$row['venue_id']}'>{$row['name']}</option>";
                            }
                            ?>
                        </select>
                    </label>
                    <br>
                    Organizer Name: <label>
                        <select name="organizer">
                            <?php
                            while ($row = pg_fetch_assoc($usersResult)) {
                                echo "<option value='{$row['user_id']}'>{$row['name']}</option>";
                            }
                            ?>
                        </select>
                    </label>
                    <br>
                    <input type="submit" value="Register">

                </form>
            </div>
        </body>

    </html>
    <?php
    include_once 'dataUpdater.php';
    $title = $description = $venue_id = $organizer_id = $start_time = $end_time = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = test_input($_POST["eventName"]);
        $description = test_input($_POST["description"]);
        $venue_id = test_input($_POST["venue"]);
        $organizer_id = test_input($_POST["organizer"]);
        $start_time = test_input($_POST["startTime"]);
        $end_time = test_input($_POST["endTime"]);


        createNewEvent($title, $description, $venue_id, $start_time, $end_time, $organizer_id);
        // The database handles updating the event_participants table through triggers.
        header("Location: index.php");
    }

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    ?>