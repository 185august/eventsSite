<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register new venue</title>
</head>
<body>
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

<?php
include 'dataUpdater.php';
$name = $email = $phone = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = test_input($_POST["name"]);
    $address = test_input($_POST["address"]);
    $phone = test_input($_POST["capacity"]);
    $email = test_input($_POST["email"]);
    createNewVenue($name, $address, $phone, $email);
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