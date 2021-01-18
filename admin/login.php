<?php
require_once "../objects/Commission.php";
require_once "../objects/Location.php";
require_once "../objects/Admin.php";

$location = new Location();
$location->redirect("admin/login.php");

$res = 0;
if (isset($_POST["login"])) {
    $res = Admin::login();
    if ($res == 1) {
        header('Location: ../admin/administration.php');
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
    <link rel="stylesheet" href="../styles/style.css">

</head>
<body>
<div class="login_container">
    <img src="../images/elections.webp" alt="banner">
    <form method="POST">
        <input type="text" name="username" placeholder="Enter username" class="space" required>
        <input type="password" name="password" placeholder="Enter password" class="space" required>

        <button class="login_button space" type="submit" name="login">Login</button>
    </form>
    <?php
    if ($res == 2) {
        echo "<div class='message'>You must fill in all data.</div>";
    } else if ($res == 3) {
        echo "<div class='message'>You have entered the wrong login name or password. Please try again.</div>";
    } else if ($res == 4){
        echo "<div class='message'>Connection problem. Please try again later.</div>";
    }
    ?>
</div>

</body>
</html>
