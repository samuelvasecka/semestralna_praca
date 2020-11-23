<?php
require_once "config/config.php";
require_once(OBJECTS_PATH . "/LocationManager.php");
$locationManager = new LocationManager();
if (strpos($_SERVER['REQUEST_URI'], "index.php")) {
    $locationManager->redirect("index.php");
} else {
    $locationManager->redirect("");
}
?>