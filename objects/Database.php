<?php
declare(strict_types=1);

class Database
{
    private string $user = "root";
    private string $pass = "dtb456";
    private string $db = "election";
    private string $host = "localhost";

    public function getConnection(): mysqli
    {
        $conn = new mysqli($this->host, $this->user, $this->pass, $this->db);
        if ($conn->connect_error) {
            $conn = null;
        }
        return $conn;
    }
}