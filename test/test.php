<?php
require_once "../config/config.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TEST</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../styles/style.css">
    <link href='https://fonts.googleapis.com/css?family=Amatic SC' rel='stylesheet'>
</head>
<body>
<div class="container">
    <div class="item">
        <div class="wedding_options">
            <button class="button">
                Vytvoriť svadbu
                <i class="fa fa-arrow-right"></i>
            </button>
            <button class="button">
                Vybrať svadbu
                <i class="fa fa-arrow-right"></i>
            </button>
        </div>
    </div>
    <div class="item">
        <button class="wedding">
            <div class="decoration_left">
                <img src='../images/corner_flower_top.png' height='90px'>
            </div>
            <div class="title">
                <div class="couple">
                    Alica & Samuel
                </div>
                <div>
                    4.12.2020
                </div>
            </div>
            <div class="decoration_right">
                <img src='../images/corner_flower_bottom.png' height='90px'>
            </div>
        </button>
    </div>
    <div class="item">
        <button class="wedding">
            <div class="decoration_left">
                <img src='../images/corner_flower_top.png' height='90px'>
            </div>
            <div class="title">
                <div class="couple">
                    Alica & Samuel
                </div>
                <div>
                    4.12.2020
                </div>
            </div>
            <div class="decoration_right">
                <img src='../images/corner_flower_bottom.png' height='90px'>
            </div>
        </button>
    </div>
    <div class="item">
        <div class="wedding_add">
            <form method="post" name="create_wedding">
                <div class="title">
                    Nová udalosť
                </div>
                <button class="close" onclick="createWedding()">
                    <i class="fa fa-times-circle" aria-hidden="true"></i>
                </button>
                <div class="container">
                    <form method="post">
                        <label>Nevesta</label>
                        <input type="text" placeholder="Nevesta" name="couple_1">
                        <label>Ženích</label>
                        <input type="text" placeholder="Ženích" name="couple_2">
                        <label>Miesto svadby</label>
                        <input type="text" placeholder="Miesto svadby" name="wedding_place">
                        <label>Dátum svadby</label>
                        <input type="date" placeholder="Dátum svadby" name="wedding_date">
                        <label>Rozpočet</label>
                        <input type="number" step="0.01" placeholder="Rozpočet" name="wedding_budget">
                        <button class="button" type="submit">
                            Vytvoriť udalosť
                            <i class="fa fa-arrow-right"></i>
                        </button>
                    </form>
                </div>
            </form>
        </div>
    </div>
    <div class="item">
        <div class="overview">
            <div class="decoration_left">
                <img src='../images/corner_flower_top.png' height='90px'>
            </div>
            <div class="title">
                <div class="couple">
                    Alica & Samuel
                </div>
                <div>
                    4.12.2020
                </div>
            </div>
            <div class="decoration_right">
                <img src='../images/corner_flower_bottom_left.png' height='90px'>
            </div>
            <div class="section">
                <div class="box">
                    <div class="box_title">
                        Alica & Samuel
                    </div>
                    <div class="detail">
                        <i class="fa fa-home" aria-hidden="true"></i>
                        Marček 100
                    </div>
                    <div class="detail">
                        <i class="fa fa-calendar" aria-hidden="true"></i>
                        4.12.2020
                    </div>
                    <button class="button">
                        <i class="fa fa-arrow-right"></i>
                    </button>
                </div>
                <div class="box">
                    <div class="box_title">
                        Checklist
                    </div>
                    <div class="detail">
                        <i class='fa fa-check-square-o' aria-hidden='true'></i>
                        Hotové - 12
                    </div>
                    <div class="detail">
                        <i class='fa fa-square-o' aria-hidden='true'></i>
                        V pláne - 3
                    </div>
                    <button class="button">
                        <i class="fa fa-arrow-right"></i>
                    </button>
                </div>
                <div class="box">
                    <div class="box_title">
                        Financie
                    </div>
                    <div class="detail">
                        <i class="fa fa-eur" aria-hidden="true"></i>
                        1550 / 3000
                    </div>
                    <button class="button">
                        <i class="fa fa-arrow-right"></i>
                    </button>
                </div>
                <div class="box">
                    <div class="box_title">
                        Hostia
                    </div>
                    <div class="detail">
                        <i class="fa fa-user-plus" aria-hidden="true"></i>
                        Potvrdený
                    </div>
                    <div class="detail">
                        <i class="fa fa-user-times" aria-hidden="true"></i>
                        Nepotvrdený
                    </div>
                    <button class="button">
                        <i class="fa fa-arrow-right"></i>
                    </button>
                </div>
                <div class="box">
                    <div class="box_title">
                        Stoly
                    </div>
                    <div class="detail">
                        <i class="fa fa-users" aria-hidden="true"></i>
                        Počet stolov - 7
                    </div>
                    <button class="button">
                        <i class="fa fa-arrow-right"></i>
                    </button>
                </div>
                <div class="box">
                    <div class="box_title">
                        Správcovia
                    </div>
                    <div class="detail">
                        <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                        Počet správcov 3
                    </div>
                    <button class="button">
                        <i class="fa fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="item">
        <div class="checklist_add">
            <div class="title">
                Nová úloha
            </div>
            <div class="close">
                <i class="fa fa-times-circle" aria-hidden="true"></i>
            </div>
            <div class="container">
                <form method="post">
                    <label>Názov</label>
                    <input type="text" placeholder="Názov" name="checklist_title">
                    <label>Poznámka</label>
                    <textarea placeholder="Poznámka" name="checklist_note"></textarea>
                    <label>Konečný termín</label>
                    <input type="date" placeholder="Konečný termín" name="checklist_deadline">
                    <input type="checkbox" name="checklist_important" placeholder="Dôležité">
                    <label>Dôležité</label>
                    <button class="button" type="submit">
                        Vytvoriť úlohu
                        <i class="fa fa-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="item">
        <div class="checklist_filter">
            <div class="container">
                <input type="text" class="search" placeholder="Search...">
                <label>Hotové</label>
                <select class="select" id="done" onchange="showResult()">
                    <option value="2" selected>Všetko</option>
                    <option value="1">Hotové</option>
                    <option value="0">V pláne</option>
                </select>
                <label>Čas</label>
                <select class="select" id="asc" onchange="showResult()">
                    <option value="2" selected>Všetko</option>
                    <option value="1">Najmenej času</option>
                    <option value="0">Najviac času</option>
                </select>
                <label>Dôležité</label>
                <select class="select" id="important" onchange="showResult()">
                    <option value="2" selected>Všetko</option>
                    <option value="1">Dôležité</option>
                    <option value="0">Ostatné</option>
                </select>
                <div class="button">
                    Vytvoriť úlohu
                    <i class="fa fa-arrow-right"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="item">
        <div class="checklist">
            <div class="title">
                Checklist
            </div>
            <div class="container">
                <div class="task">
                    <button class="button">
                        <i class="fa fa-check-square-o" aria-hidden="true"></i>
                    </button>
                    <button class="button">
                        <i class="fa fa-exclamation" aria-hidden="true"></i>
                    </button>
                    <div class="date">
                        <button class="change_button">
                            4.12.2020
                        </button>
                    </div>
                    <div class="checklist_title">
                        <button class="change_button">
                            Zajednanie sály
                        </button>
                    </div>
                    <div class="checklist_note">
                        <button class="change_button">
                            Treba dostatočne skoro dopredu zajednať sálu na svadbu.
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="item">
        <div class="error">
            <div class="error_title">
                Chyba
            </div>
            Vyskytla sa neočakávaná chyba!
        </div>
    </div>
</div>
</body>
</html>
