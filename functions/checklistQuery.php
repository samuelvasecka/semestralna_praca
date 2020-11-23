<?php
declare(strict_types=1);
require_once "../config/config.php";
require_once(OBJECTS_PATH . "/CookieManager.php");
require_once(OBJECTS_PATH . "/FilterChecklist.php");
require_once(OBJECTS_PATH . "/Task.php");
$cookieManager = new CookieManager();
$checklistFilter = new FilterChecklist();
echo "<script type='text/javascript'>alert('data');</script>";
if (isset($_GET["s"]) && isset($_GET["d"]) && isset($_GET["a"]) && isset($_GET["i"]) && isset($_GET["wid"]) && $cookieManager->isUserLogged()) {
    $array = [];
    if ($_GET["s"] == 1) {
        $array = $checklistFilter->searchBy($_GET["text"], (int)$_GET["wid"]);
    } else {
        $array = $checklistFilter->multipleSort((int)$_GET["d"], (int)$_GET["i"], (int)$_GET["a"], (int)$_GET["wid"]);
    }
    $html = "";
    foreach ($array as $value) {
        $html.= $value->getTaskHTML();
    }
    echo $html;
}
?>