<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register new user</title>
</head>
<body>
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

<?php
include 'dataUpdater.php';
$name = $email = $phone = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = test_input($_POST["name"]);
    $email = test_input($_POST["email"]);
    $phone = test_input($_POST["phone"]);

    createNewUser($name, $email, $phone);

    header("Location: index.php");
    exit();
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>
</body>
</html>