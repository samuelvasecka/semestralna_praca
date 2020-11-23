<?php
if(isset($_POST["logout"])) {
    $cookieManager = new CookieManager();
    $cookieManager->destroyUserId();
    header('Location: login.php');
    exit();
}
?>

<div class="header">
    <img src="images/logo_next_text_copy_2.png" alt="logo" height="48">
    <div class="menu">
        <form method="post">
            <button type="submit" name="logout">
                <i class="fa fa-sign-out"></i>
            </button>
        </form>
    </div>
    <div class="menu">
        <a href="#"><i class="fa fa-cutlery"></i><div class="inline">Stoly</div></a>
    </div>
    <div class="menu">
        <a href="#"><i class="fa fa-user"></i><div class="inline">Hostia</div></a>
    </div>
    <div class="menu">
        <a href="#"><i class="fa fa-euro"></i><div class="inline">Financie</div></a>
    </div>
    <div class="menu">
        <a href="checklist.php"><i class="fa fa-check-circle-o"></i><div class="inline">Checklist</div></a>
    </div>
    <div class="menu">
        <a href="index.php"><i class="fa fa-home"></i><div class="inline">Domov</div></a>
    </div>
</div>
