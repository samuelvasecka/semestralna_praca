

<?php
include "../semestralna_praca/php/common/database.php";

$cookie_name = "user_id";
if (!isset($_COOKIE[$cookie_name])) {

} else {
    if ( $_COOKIE[$cookie_name] == -1) {

    } else {
        echo '<script type="text/javascript">
           window.location = "index.php"
      </script>';
    }
}

if (isset($_POST['email'])) {
    $conn = getConnection();

    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($conn == null) {
        echo "<script>alert(\"Connection Error!\")</script>";
    } else {
        $sql = "SELECT id FROM users WHERE email='" . $email . "' AND password='" . $password . "'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $cookie_name = "user_id";
                $cookie_value = $row["id"];
                setcookie($cookie_name, $cookie_value, time() + (86400 * 30));
                echo '<script>
                            window.location.href = "index.php";
                            </script>';
            }
            $conn->close();
        } else {
            echo "<script>alert(\"Failed login!\")</script>";
            $conn->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles/styleLogin.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../semestralna_praca/images/logo-new-small.png">
</head>
<body>
<img src="images/background-city.png" class="background">
<div class="container">
    <div class="redCon2">
        <div class="con">
            <div class="item">
                <img class="center-logo" src="../semestralna_praca/images/logo-new-small.png">
                <div class="form">
                    <form method="POST">
                        <input type="email" id="email" class="email" placeholder="Enter email" name="email" required/>
                        <input type="password" id="password" class="password" placeholder="Enter password" name="password"
                               required/>
                        <button type="submit" class="login-button">
                            Login
                        </button>
                    </form>
                    <hr/>
                    <form action="registration.php">
                        <button type="submit" class="login-button">
                            Register
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
