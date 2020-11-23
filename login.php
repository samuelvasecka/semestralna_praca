<?php
require_once "config/config.php";
require_once(OBJECTS_PATH . "/LocationManager.php");
require_once(OBJECTS_PATH . "/Database.php");

$locationManager = new LocationManager();
$locationManager->redirect("login.php");
$database = new Database();

if (isset($_POST["email"]) && isset($_POST["password"])) {
    if ($database->loginUser($_POST["email"], $_POST["password"])) {
        header('Location: index.php');
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">

</head>
<body>
    <div  class="login_block">
        <form method="post" class="item">

            <input type="email" name="email" placeholder="Enter email" required>
            <input type="password" name="password" placeholder="Enter password" required>

            <button class="button" type="submit">Login</button>

        </form>
        <form action="registration.php">
            <button class="button">Register</button>
        </form>
    </div>


</body>
</html>

