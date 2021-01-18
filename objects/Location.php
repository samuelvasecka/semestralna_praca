<?php
declare(strict_types=1);
require_once "Cookies.php";

class Location
{
    public function redirect(string $location): void
    {
        $cookies = new Cookies();
        switch ($location) {
            case "commission/registration.php":
            case "commission/login.php":
                if ($cookies->isCommissionLogged()) {
                    header('Location: ../country/administration.php');
                    exit();
                }
                break;
            case "admin/login.php":
                if ($cookies->isAdminLogged()) {
                    header('Location: administration.php');
                    exit();
                }
                break;
            case "index.php":
                if ($cookies->isCommissionLogged()) {
                    header('Location: country/administration.php');
                    exit();
                } else if ($cookies->isAdminLogged()) {
                    header('Location: admin/administration.php');
                    exit();
                } else {
                    header('Location: home.php');
                    exit();
                }
                break;
            case "":
                if ($cookies->isCommissionLogged()) {
                    header('Location: semestralna_praca/country/administration.php');
                    exit();
                } else if ($cookies->isAdminLogged()) {
                    header('Location: semestralna_praca/admin/administration.php');
                    exit();
                } else {
                    header('Location: semestralna_praca/home.php');
                    exit();
                }
                break;
            case "country/history.php":
            case "country/administration.php":
                if (!$cookies->isCommissionLogged()) {
                    header('Location: ../home.php');
                    exit();
                }
                break;
            case "admin/administration.php":
                if ($cookies->isAdminLogged() == false) {
                    header('Location: login.php');
                    exit();
                }
                break;
        }
    }

    public function postRedirect(string $location): void
    {
        header('Location: ' . $location, true, 303);
        exit();
    }
}