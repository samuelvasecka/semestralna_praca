<?php
declare(strict_types=1);
require_once "Database.php";
require_once "Cookies.php";

class Admin
{
    static public function login() : int {
        if (isset($_POST["username"]) && isset($_POST["password"])) {
            $database = new Database();
            $conn = $database->getConnection();

            if (isset($conn)) {
                $cookies = new Cookies();
                $username = $_POST["username"];
                $password = self::doEncrypt($_POST["password"]);

                $sql = "SELECT * FROM commission WHERE username='" . $username . "'  AND password = '" . $password . "' AND role_type=1 AND confirmed=1";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $cookies->setAdminId((int)$row["id"]);
                        $cookies->destroyCommissionId();
                    }
                    return 1;
                } else {
                    return 3;
                }
            } else {
                return 4;
            }
            $conn->close();
        } else {
            return 2;
        }
    }

    static public function logout() : bool {
        $cookies = new Cookies();
        $cookies->destroyAdminId();
        return true;
    }

    static private function doEncrypt($plain_text)
    {
        return hash('sha256', $plain_text);
    }
}