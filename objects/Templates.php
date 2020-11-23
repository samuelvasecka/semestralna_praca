<?php


class Templates
{
    public static function getError(): string
    {
        return
            '<div class="container">
                <div class="error">
                    <div class="error_title">
                        Chyba
                    </div>
                    Vyskytla sa neočakávaná chyba!
                </div>
            </div>';
    }

    public static function getWeddingOptions() :string {
        return '<div class="item">
        <div class="wedding_options">
            <button class="button" onclick="createWedding() ">
                Nová svadba
                <i class="fa fa-arrow-right"></i>
            </button>
            <form method="post">
            <button class="button" type="submit" name="get_weddings">
                Vybrať svadbu
                <i class="fa fa-arrow-right"></i>
            </button>
        </form>
        </div>
    </div>';
    }

    public static function getChecklistFilter() : string {
        return
        '<div class="item">
        <div class="checklist_filter">
            <div class="container">
                <input type="text" id="search_checklist" onkeyup="showChecklist()" class="search" placeholder="Search...">
                <select class="select" id="done_checklist" onchange="showChecklist()">
                    <option value="2" selected>Všetko</option>
                    <option value="1">Hotové</option>
                    <option value="0">V pláne</option>
                </select>
                <select class="select" id="asc_checklist" onchange="showChecklist()">
                    <option value="2" selected>Všetko</option>
                    <option value="1">Najmenej času</option>
                    <option value="0">Najviac času</option>
                </select>
                <select class="select" id="important_checklist" onchange="showChecklist()">
                    <option value="2" selected>Všetko</option>
                    <option value="1">Dôležité</option>
                    <option value="0">Ostatné</option>
                </select>
                <div class="button" onclick="createTask()">
                    Vytvoriť úlohu
                    <i class="fa fa-arrow-right"></i>
                </div>
            </div>
        </div>
    </div>';
    }
}