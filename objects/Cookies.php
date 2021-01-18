<?php

class Cookies
{
    private string $commissionId = "commission_id";
    private string $adminId = "admin_id";


    public function setCommissionId(int $id) : void {
        setcookie($this->commissionId, $id."", time() + (86400 * 30), "/");
    }

    public function destroyCommissionId() : void {
        setcookie($this->commissionId, "-1", time() - 86400, "/");
    }

    public function isCommissionLogged() : bool {
        if (isset($_COOKIE[$this->commissionId])) {
            if ($_COOKIE[$this->commissionId] != -1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getCommissionId() : int {
        return (int)$_COOKIE[$this->commissionId];
    }

    public function setAdminId(int $id) : void {
        setcookie($this->adminId, $id."", time() + (86400 * 30), "/");
    }

    public function destroyAdminId() : void {
        setcookie($this->adminId, "-1", time() - 86400, "/");
    }

    public function isAdminLogged() : bool {
        if (isset($_COOKIE[$this->adminId])) {
            if ($_COOKIE[$this->adminId] != -1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getAdminId() : int {
        return (int)$_COOKIE[$this->adminId];
    }
}