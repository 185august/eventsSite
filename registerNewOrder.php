<!doctype html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Register New Order</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <div class="data-container">
            <a href="index.php" class="button-link">Go back</a>
            <?php
            include_once 'dataFetcher.php';
            include_once 'dbConnection.php';
            $dataFetcher = new DataFetcher();

            $usersResult = $dataFetcher->fetchUsers();
            $eventsResult = $dataFetcher->fetchEvents();
            $rolesResult = $dataFetcher->fetchEventRoles();

            $selected_user_id = $_POST['user'] ?? null;
            $selected_event_id = $_POST['event'] ?? null;
            $selected_role_id = $_POST['role'] ?? null;

            $ticketsRows = [];
            if ($selected_event_id) {
                $ticketsResult = $dataFetcher->fetchTicketsByEventId($selected_event_id);
                if ($ticketsResult) {
                    while ($row = pg_fetch_assoc($ticketsResult)) {
                        $ticketsRows[$row['ticket_id']] = $row;
                    }
                }
            }
            ?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <?php if ($selected_user_id) {
                    echo "<input type='hidden' name='user' value='{$selected_user_id}'>";
                } ?>

                <h1>Select User</h1>
                <select name="user" onchange="this.form.submit()">
                    <option value="">-- Select a User --</option>
                    <?php
                    if ($usersResult) {
                        pg_result_seek($usersResult, 0); // Reset pointer
                        while ($row = pg_fetch_assoc($usersResult)) {
                            $selected = ($row['user_id'] == $selected_user_id) ? 'selected' : '';
                            echo "<option value='{$row['user_id']}' {$selected}>{$row['name']}</option>";
                        }
                    }
                    ?>
                </select>
                <br>

                <?php if ($selected_user_id): ?>
                    <h1>Select Event</h1>
                    <select name="event" onchange="this.form.submit()">
                        <option value="">-- Select an Event --</option>
                        <?php
                        if ($eventsResult) {
                            pg_result_seek($eventsResult, 0);
                            while ($row = pg_fetch_assoc($eventsResult)) {
                                $selected = ($row['event_id'] == $selected_event_id) ? 'selected' : '';
                                echo "<option value='{$row['event_id']}' {$selected}>{$row['title']}</option>";
                            }
                        }
                        ?>
                    </select>
                    <br>
                <?php endif; ?>

                <?php if ($selected_user_id && $selected_event_id && !empty($ticketsRows)): ?>
                    <h1>Select Ticket and Quantity</h1>
                    <label for="ticket_id">Ticket Type:
                        <select name="ticket_id">
                            <option value="">-- Select a Ticket Type --</option>
                            <?php
                            foreach ($ticketsRows as $ticket_id => $ticket_data) {
                                echo "
                                <option value='{$ticket_id}'>
                                {$ticket_data['ticket_type']} (Available: {$ticket_data['available_quantity']}, Price: {$ticket_data['price']}$)
                                </option>";
                            }
                            ?>
                        </select>
                    </label>
                    <br>
                    <label for="quantity">Quantity:
                        <input type="number" name="quantity" min="1" value="1">
                    </label>
                    <label for="event_role">Select event role:
                        <select name="role_id">
                            <?php if ($rolesResult) {
                                pg_result_seek($rolesResult, 0);
                                while ($row = pg_fetch_assoc($rolesResult)) {
                                    $selected = ($row['role_id'] == $selected_role_id) ? 'selected' : '';
                                    echo "<option value='{$row['role_id']}' {$selected}>{$row['role_name']}</option>";
                                }
                            }
                            ?>
                        </select>

                    </label>
                    <br>
                    <label for="payment_method">Select Payment Method
                        <select name="payment_method">
                            <option value="Paypal">Paypal</option>
                            <option value="Credit Card">Credit Card</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                        </select>
                    </label>
                    <br>
                    <input type="submit" name="submit_order" value="Register Order">
                <?php elseif ($selected_event_id): ?>
                    <p>No tickets are available for this event.</p>
                <?php endif; ?>
            </form>
        </div>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_order'])) {
            include_once 'dataUpdater.php';

            $user_id = testInput($_POST["user"]);
            $ticket_id = testInput($_POST["ticket_id"]);
            $quantity = testInput($_POST["quantity"]);

            if ($ticket_id && $quantity > 0) {
                $order_id = createNewOrder($user_id);

                $price = $ticketsRows[$ticket_id]['price'];
                createNewOrderItem($order_id, $ticket_id, $quantity, $price);

                registerPayment($order_id, testInput($_POST["payment_method"]));

                createNewEventParticipants($selected_event_id, $selected_user_id, $selected_role_id);

                echo "<script>window.location.href='index.php';</script>";
                exit();
            } else {
                echo "<p style='color:red;'>Please select a ticket type and quantity.</p>";
            }
        }
        ?>
    </body>

</html>