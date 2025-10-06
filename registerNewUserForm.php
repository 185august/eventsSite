<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Register new user</title>
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
                Email: <label>
                    <input name="email" required type="text">
                </label>
                <br>
                Phone: <label>
                    <input name="phone" required type="tel">
                </label>
                <br>
                <input type="submit" value="Register">

            </form>
        </div>
        <?php
        include_once 'dataUpdater.php';
        include_once 'dbConnection.php';
        $name = $email = $phone = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = testInput($_POST["name"]);
            $email = testInput($_POST["email"]);
            $phone = testInput($_POST["phone"]);

            createNewUser($name, $email, $phone);

            header("Location: index.php");
            exit();
        }



        ?>
    </body>

</html>