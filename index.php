<?php
require_once "objects/Location.php";

$location = new Location();
if (strpos($_SERVER['REQUEST_URI'], "index.php")) {
    $location->redirect("index.php");
} else {
    $location->redirect("");
}
