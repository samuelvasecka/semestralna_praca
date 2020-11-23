<?php
declare(strict_types=1);
require_once "CookieManager.php";

class LocationManager
{
    public function redirect(string $location) : void {
        $cookieManager = new CookieManager();
        switch ($location) {
            case "registration.php":
            case "login.php":
                if ($cookieManager->isUserLogged()) {
                    header('Location: home.php');
                    exit();
                }
                break;
            case "index.php":
                if ($cookieManager->isUserLogged()) {
                    header('Location: home.php');
                    exit();
                } else {
                    header('Location: login.php');
                    exit();
                }
                break;
            case "":
                if ($cookieManager->isUserLogged()) {
                    header('Location: semestralna_praca/home.php');
                    exit();
                }  else {
                    header('Location: semestralna_praca/login.php');
                    exit();
                }
                break;
            default:
                if ($cookieManager->isUserLogged() == false) {
                    header('Location: login.php');
                    exit();
                }
                break;
        }
    }

    public function postRedirect(string $location): void {
        header('Location: '.$location, true, 303);
        exit();
    }
}