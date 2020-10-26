<?php
function getConnection()
{
    $host = 'localhost';
    $db_name = 'database';
    $username = 'root';
    $password = 'dtb456';
    $conn = new mysqli($host, $username, $password, $db_name);
    if ($conn->connect_error) {
        $conn = null;
    }
    return $conn;
}
?>
