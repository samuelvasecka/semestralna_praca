<?php
require_once "config/config.php";
require_once(OBJECTS_PATH . "/LocationManager.php");
require_once(OBJECTS_PATH . "/CookieManager.php");
require_once(OBJECTS_PATH . "/User.php");
require_once(OBJECTS_PATH . "/Templates.php");
require_once (OBJECTS_PATH . "/Wedding.php");
$locationManager = new LocationManager();
$locationManager->redirect("home.php");
if(isset($_POST["logout"])) {
    $cookieManager = new CookieManager();
    $cookieManager->destroyUserId();
    header('Location: login.php');
    exit();
}

if (isset($_POST["choose_wedding"])) {
    $cookieManager = new CookieManager();
    $database = new Database();
    $array = User::getUser();
    if (count($array) != 0) {
        $user = User::getUserFromArray($array);
        $user->setActualWedding((int)$_POST["choose_wedding"]);
        $user->updateActualWedding();
        header('Location: home.php');
        exit();
    }
}

if (isset($_POST["get_weddings"])) {
    $cookieManager = new CookieManager();
    $database = new Database();
    $array = User::getUser();
    if (count($array) != 0) {
        $user = User::getUserFromArray($array);
        $user->setActualWedding(0);
        $user->updateActualWedding();
        header('Location: home.php');
        exit();
    }
}

if (isset($_POST["create_wedding"]) && isset($_POST["couple_1"])  && isset($_POST["couple_2"])  && isset($_POST["wedding_place"])  && isset($_POST["wedding_date"]) && isset($_POST["wedding_budget"])) {
    $wedding = new Wedding(-1, $_POST["wedding_date"], $_POST["wedding_place"], $_POST["couple_1"] ." & ". $_POST["couple_2"], $_POST["wedding_budget"] );
    if ($wedding->insertWedding()) {
        header('Location: home.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles/style.css">
    <link href='https://fonts.googleapis.com/css?family=Amatic+SC' rel='stylesheet'>
</head>
<body>
<?php require_once "templates/menuTop.php"; ?>
<?php require_once "templates/menuBottom.php"; ?>
<div class="container">
    <?php
    echo Templates::getWeddingOptions();
    ?>
    <div class="hide" id="create_wedding">
        <div class="item">
            <div class="wedding_add">
                    <div class="title">
                        Nová udalosť
                    </div>
                    <button class="close" onclick="createWedding()">
                        <i class="fa fa-times-circle" aria-hidden="true"></i>
                    </button>
                    <div class="container">
                        <form method="post">
                            <label>Nevesta</label>
                            <input type="text" placeholder="Nevesta" name="couple_1"  required>
                            <label>Ženích</label>
                            <input type="text" placeholder="Ženích" name="couple_2"  required>
                            <label>Miesto svadby</label>
                            <input type="text" placeholder="Miesto svadby" name="wedding_place"  required>
                            <label>Dátum svadby</label>
                            <input type="date" name="wedding_date"  required>
                            <label>Rozpočet</label>
                            <input type="number" step="0.01" placeholder="Rozpočet" name="wedding_budget"  required>
                            <button class="button" name="create_wedding" type="submit">
                                Vytvoriť udalosť
                                <i class="fa fa-arrow-right"></i>
                            </button>
                        </form>
                    </div>
            </div>
        </div>
    </div>
    <?php
    $array = User::getUser();
    if (count($array) != 0) {
        $user = User::getUserFromArray($array);
        if ($user->getActualWedding() != 0) {
            $wedding = Wedding::getWedding($user->getActualWedding());
            echo $wedding->getBigWeddingHTML();
        } else {
            $weddings = Wedding::getMyWeddings();
            foreach ($weddings as $wedding) {
                echo $wedding->getSmallWeddingHTML();
            }
        }
    } else {
        echo Templates::getError();
    }
    ?>
</div>
<script>
    function createWedding() {
        var item = document.getElementById("create_wedding");
        if (item.className === "hide") {
            item.className = "";
        } else {
            item.className = "hide";
        }
    }
</script>
</body>
</html>
