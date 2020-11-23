<?php
require_once "../config/config.php";
require_once(OBJECTS_PATH . "/Database.php");

if (isset($_GET["id"]) && isset($_GET["done"])) {
    $database = new Database();
    $conn = $database->getConnection();
    if (isset($conn)) {
        $sql = "UPDATE checklists SET done=" . (int)$_GET["done"] . " WHERE id = " . (int)$_GET["id"];
        //echo $sql;
        $result = $conn->query($sql);
        $icon = "fa fa-square-o";
        if ((int)$_GET["done"] == 1) {
            $icon = "fa fa-check-square";
        }
        echo '<i class="'.$icon.'" aria-hidden="true"></i>';
    } else {
        $icon = "fa fa-square-o";
        if ((int)$_GET["done"] == 2) {
            $icon = "fa fa-check-square";
        }
        echo '<i class="'.$icon.'" aria-hidden="true"></i>';
    }
}