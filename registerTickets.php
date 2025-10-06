<!doctype html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Register new Tickets</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <div class="data-container">


            <a href="index.php" class="button-link">Go back</a>
            <?php
            include_once 'dataFetcher.php';
            $dataFetcher = new DataFetcher();
            $eventsResult = $dataFetcher->fetchEvents();
            $ticketTypesResult = $dataFetcher->fetchTicketTypes();

            $event_id = $_POST['event_id'] ?? $_GET['event_id'] ?? null;
            $ticketResults = $dataFetcher->fetchTicketsByEventId($event_id);
            $ticketRows = [];
            if ($ticketResults) {
                while ($row = pg_fetch_assoc($ticketResults)) {
                    $ticketRows[$row['ticket_type_id']] = $row;
                }
            }
            echo "<script>console.log('Tickets array:', " . json_encode($ticketRows) . ");</script>";
            ?>


            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($event_id); ?>">
                <h1>Select Ticket Type, Quantitiy and Price:</h1>
                <?php
                while ($row = pg_fetch_assoc($ticketTypesResult)) {
                    $ticketTypeId = $row['ticket_type_id'];
                    $quantity = isset($ticketRows[$ticketTypeId]) ? $ticketRows[$ticketTypeId]['available_quantity'] : 0;
                    $price = isset($ticketRows[$ticketTypeId]) ? $ticketRows[$ticketTypeId]['price'] : '0.00';

                    echo "<label>{$row['ticket_type']} 
            <input type='number' name='ticketType{$ticketTypeId}' min='0' value='{$quantity}'>
          </label>
          Price per ticket $: <label>
            <input name='price{$ticketTypeId}' type='number' step='0.01' min='0' value='{$price}'>
          </label>
          <br>";
                }
                ?>
                <br>

                <br>
                <input type="submit" value="Register">

            </form>
        </div>
        <?php
        include_once 'dbConnection.php';
        include_once 'dataUpdater.php';
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $event_id = testInput($_POST["event_id"]);
            for ($i = 1; $i <= 5; $i++) {
                $quantity = testInput($_POST["ticketType$i"]);
                $price = testInput($_POST["price$i"]);
                if (!empty($ticketRows)) {
                    foreach ($ticketRows as $row) {
                        if ($row['ticket_type_id'] == $i) {
                            $ticket_id = $row['ticket_id'];
                            updateTicketQuantity($ticket_id, $quantity, $price);
                            $quantity = -1;
                        }
                    }
                }
                if ($quantity > 0) {
                    createNewTickets($event_id, $i, $price, $quantity);
                }
            }
            header("Location: index.php");
        }
        ?>
    </body>

</html>