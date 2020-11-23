<?php
require_once "../config/config.php";
require_once(OBJECTS_PATH . "/Database.php");

if (isset($_GET["id"])) {
    $database = new Database();
    $conn = $database->getConnection();
    if (isset($conn)) {
        $sql = "DELETE FROM checklists WHERE id=" . $_GET["id"];
        $result = $conn->query($sql);
    }
}
