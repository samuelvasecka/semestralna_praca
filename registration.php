<?php
require_once "config/config.php";
require_once(OBJECTS_PATH . "/LocationManager.php");
require_once(OBJECTS_PATH . "/Database.php");
$locationManager = new LocationManager();
$locationManager->redirect("registration.php");
$database = new Database();
if (isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["full_name"])) {
    if ($database->registerUser($_POST["email"], $_POST["full_name"], $_POST["password"])) {
        header('Location: index.php');
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
<div class="login_block">
    <form method="post" class="item">
            <input type="email" name="email" placeholder="Enter email" required>

            <input type="text" name="full_name" placeholder="Enter full name" required>

            <input type="password" name="password" placeholder="Enter password" required>

            <button class="button" type="submit">Register</button>

    </form>
    <form action="login.php">
            <button class="button">Login</button>
    </form>
</div>
</body>
</html>
