<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <title>Login</title>
    <link rel="stylesheet" href="styles/myFramework.css"/>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/logo.png">
</head>

<body class="c-bg-bg">
<div class="header-space">
    <br/>
</div>
<div class="container-fl login-body flex pad-t-sm pad-b-sm">
    <div class="center login-col c-bg-cmpnt radius-12 ">
        <div class="login-icon pad-t-big text-c">
            <img alt="logo" src="images/logo.png" height="128"/>
        </div>
        <div class="container80 pad-b-big">
            <input type="email" class="radius-12 c-bg-bg" placeholder="Enter Email" name="email" required/>
            <input type="password" class="radius-12 c-bg-bg" placeholder="Enter Password" name="psw" required/>
            <form action="index.php">
                <button type="submit" onclick="" class="button button-col down radius-12 pad-t-big pad-b-big">Sign in
                    <i class="fa fa-arrow-right c-text-pink mar-l-sm"></i>
                </button>
            </form>
            <div class="mar-t-sm">
                <label>
                    <input type="checkbox" checked="checked" name="remember"> Remember me
                </label>
            </div>
            <div class="mar-t-big mar-b-big">
                <hr class="container80 ">
            </div>
            <form action="register.php">
                <button type="submit" class="button button-col down radius-12 pad-t-big pad-b-big">Or sign up
                    <i class="fa fa-user-plus c-text-pink login-icon mar-l-sm"></i>
                </button>
            </form>
        </div>
    </div>
</div>
<?php include('../semestralna_praca/templates/header.php') ?>
</body>
</html>
