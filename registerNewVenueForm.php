<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Register new venue</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <div class="data-container">
            <a href="index.php" class="button-link">Go back</a>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                Name: <label>
                    <input name="name" required type="text">
                </label>
                <br>
                Address: <label>
                    <input name="address" required type="text">
                </label>
                <br>
                Capacity: <label>
                    <input name="capacity" required type="number">
                </label>
                <br>
                Email address: <label>
                    <input name="email" required type="email">
                </label>
                <br>
                <input type="submit" value="Register">

            </form>
        </div>
        <?php
        include 'dataUpdater.php';
        include_once 'dbConnection.php';
        $name = $email = $phone = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = testInput($_POST["name"]);
            $address = testInput($_POST["address"]);
            $phone = testInput($_POST["capacity"]);
            $email = testInput($_POST["email"]);
            createNewVenue($name, $address, $phone, $email);

            header("Location: index.php");
        }


        ?>
    </body>

</html>