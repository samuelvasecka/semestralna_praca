<?php
require_once "../config/config.php";
require_once(OBJECTS_PATH . "/Database.php");
require_once(OBJECTS_PATH . "/Task.php");

if (isset($_GET["id"]) && isset($_GET["title"]) && isset($_GET["note"]) && isset($_GET["date"])) {
    $database = new Database();
    $conn = $database->getConnection();
    if (isset($conn)) {
        $sql = "UPDATE checklists SET title='" . $_GET["title"] . "', note='" . $_GET["note"] . "', deadline='" . $_GET["date"] . "' WHERE id = " . $_GET["id"];
        $result = $conn->query($sql);
        echo Task::getTask((int)$_GET["id"])->getTaskHTML();
    } else {
        echo Task::getTask((int)$_GET["id"])->getTaskHTML();
    }
}