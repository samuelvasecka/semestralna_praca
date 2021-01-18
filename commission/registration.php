<?php
require_once "../objects/Commission.php";
require_once "../objects/Location.php";
require_once "../objects/Country.php";

$location = new Location();
$location->redirect("commission/registration.php");



$res = 0;
if (isset($_POST["register"])) {
    $res = Commission::register();
    if ($res == 1) {
        header('Location: ../commission/login.php');
        exit();
    }
}

$countries = Country::getCountries();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">

</head>
<body>
<div class="login_container">
    <img src="../images/elections.webp" alt="banner">
    <form method="POST">
        <input type="text" name="username" placeholder="Enter username" class="space" required>
        <input type="password" name="password" placeholder="Enter password" class="space"  required>

        <select name="country_id">
            <?php
            foreach ($countries as $country) {
                ?><option value="<?php echo $country->id; ?>"><?php echo $country->name; ?></option><?php
            }
            ?>
        </select>
        <button type="submit" class="login_button space" name="register">Register</button>
    </form>
    <?php
    if ($res == 2) {
        echo "<div class='message space'>You must fill in all data.</div>";
    } else if ($res == 3) {
        echo "<div class='message space'>Username is already used. Try another.</div>";
    } else if ($res == 4){
        echo "<div class='message space'>Connection problem. Please try again later.</div>";
    } else if ($res == 5) {
        echo "<div class='message space'>Username and password must be at least 8 characters long and max 256 characters long.</div>";
    }
    ?>
    <form action="login.php">
        <button class="login_button space">Login</button>
    </form>
</div>
</body>
</html>