<?php
declare(strict_types=1);

class Database
{
    private string $user = "root";
    private string $pass = "dtb456";
    private string $db = "wedding_planner";
    private string $host = "localhost";

    public function getConnection(): mysqli
    {
        $conn = new mysqli($this->host, $this->user, $this->pass, $this->db);
        if ($conn->connect_error) {
            $conn = null;
        }
        return $conn;
    }

    public function doEncrypt($plain_text)
    {
        return hash('sha256', $plain_text);
    }

    public function loginUser($email, $password): bool
    {
        $cookieManager = new CookieManager();
        $conn = $this->getConnection();
        if (isset($conn)) {
            $password = $this->doEncrypt($password);
            $sql = "SELECT * FROM users WHERE email='" . $email . "'  AND password = '" . $password . "'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $cookieManager->setUserId((int)$row["id"]);
                }
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
        $conn->close();
    }

    public function registerUser($email, $fullName, $password): bool
    {
        $conn = $this->getConnection();
        if (isset($conn)) {
            $sql = "SELECT email FROM users WHERE email='" . $email . "'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                return false;
            } else {
                $passwordEnc = $this->doEncrypt($password);
                $sql = "INSERT INTO users(full_name, email, password) VALUES ('" . $fullName . "', '" . $email . "', '" . $passwordEnc . "')";
                $result = $conn->query($sql);
                if ($result) {
                    return $this->loginUser($email, $password);
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
        $conn->close();
    }
}