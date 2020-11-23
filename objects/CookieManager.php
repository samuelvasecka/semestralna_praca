<?php
declare(strict_types=1);

class CookieManager
{
    private string $userId = "user_id";

    public function setUserId(int $id) : void {
        setcookie($this->userId, $id."", time() + (86400 * 30));
    }

    public function destroyUserId() : void {
        setcookie($this->userId, "-1", time() - 86400);
    }

    public function isUserLogged() : bool {
        if (isset($_COOKIE[$this->userId])) {
            if ($_COOKIE[$this->userId] != -1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getUserId() : int {
        return (int)$_COOKIE[$this->userId];
    }
}