<?php
require_once "config/config.php";
require_once(OBJECTS_PATH . "/LocationManager.php");
require_once(OBJECTS_PATH . "/Templates.php");
require_once(OBJECTS_PATH . "/User.php");
require_once(OBJECTS_PATH . "/Task.php");
$locationManager = new LocationManager();
$locationManager->redirect("checklist.php");

if (isset($_POST["checklist_title"]) && isset($_POST["checklist_note"]) && isset($_POST["checklist_deadline"])) {
    $array = User::getUser();
    $imporant = 0;
    if (isset($_POST["checklist_important"])) {
        $imporant = 1;
    }
    if (count($array) != 0) {
        $user = User::getUserFromArray($array);
        $task = new Task(-1, $_POST["checklist_title"], $_POST["checklist_note"], 0, $_POST["checklist_deadline"], $imporant, $user->getActualWedding());
        $task->insertTask();
        $locationManager->redirect("checklist.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checklist</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Amatic+SC' rel='stylesheet'>
</head>
<body>
<?php require_once "templates/menuTop.php"; ?>
<?php require_once "templates/menuBottom.php"; ?>
<div class="container">
    <?php
    $array = User::getUser();
    if (count($array) != 0) {
        $user = User::getUserFromArray($array);
        if ($user->getActualWedding() != 0) {
            $tasks = Task::getMyTasks($user->getActualWedding());
            if (count($tasks) != 0) {
                echo "<input type='hidden' value='" . $user->getActualWedding() . "' id='weddingId'>";
                echo Templates::getChecklistFilter();
                ?>
                <div class="hide" id="create_task">
                    <div class="item">
                        <div class="checklist_add">
                            <div class="title">
                                Nová úloha
                            </div>
                            <button class="close" onclick="createTask()">
                                <i class="fa fa-times-circle" aria-hidden="true"></i>
                            </button>
                            <div class="container">
                                <form method="post">
                                    <label>Názov</label>
                                    <input type="text" placeholder="Názov" name="checklist_title"  required>
                                    <label>Poznámka</label>
                                    <textarea placeholder="Poznámka" name="checklist_note"  required></textarea>
                                    <label>Konečný termín</label>
                                    <input type="date" name="checklist_deadline"  required>
                                    <input type="checkbox" name="checklist_important">
                                    <label>Dôležité</label>
                                    <button class="button" type="submit">
                                        Vytvoriť úlohu
                                        <i class="fa fa-arrow-right"></i>
                                    </button>
                                </form>
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
                            <div id="content">

                            </div>
                        </div>
                    </div>
                </div>

                <?php
            } else {
                echo "<input type='hidden' value='" . $user->getActualWedding() . "' id='weddingId'>";
                echo Templates::getChecklistFilter();
                ?>
                <div class="item">
                    <div class="container_help">
                        <form action="home.php">
                            <button class="button">
                                Nemáte žiadne úlohy.
                                <i class="fa fa-arrow-right"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="hide" id="create_task">
                    <div class="item">
                        <div class="checklist_add">
                            <div class="title">
                                Nová úloha
                            </div>
                            <button class="close" onclick="createTask()">
                                <i class="fa fa-times-circle" aria-hidden="true"></i>
                            </button>
                            <div class="container">
                                <form method="post">
                                    <label>Názov</label>
                                    <input type="text" placeholder="Názov" name="checklist_title" required>
                                    <label>Poznámka</label>
                                    <textarea placeholder="Poznámka" name="checklist_note" required></textarea>
                                    <label>Konečný termín</label>
                                    <input type="date" name="checklist_deadline" required>
                                    <input type="checkbox" placeholder="Dôležité">
                                    <label>Dôležité</label>
                                    <button class="button" type="submit">
                                        Vytvoriť úlohu
                                        <i class="fa fa-arrow-right"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="item">
                <div class="container_help">
                    <form action="home.php">
                        <button class="button">
                            Nemáte vybratú žiadnu svadbu.
                            <i class="fa fa-arrow-right"></i>
                        </button>
                    </form>
                </div>
            </div>
            <?php
        }
    } else {
        echo Templates::getError();
    }
    ?>
</div>
<script>

    $(document).ready(
        showChecklist()
    );

    function showChecklist() {
        var search = 0;
        var text = "";
        var done = document.getElementById("done_checklist").value;
        var asc = document.getElementById("asc_checklist").value;
        var important = document.getElementById("important_checklist").value;
        var weddingId = document.getElementById("weddingId").value;

        if (document.getElementById("search_checklist").value != "" && document.getElementById("search_checklist").value != null) {
            text = document.getElementById("search_checklist").value;
            search = 1;
        }
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("content").innerHTML = this.responseText;
            }
        }
        xmlhttp.open("GET", "http://localhost/semestralna_praca/functions/checklistQuery.php?text=" + text + "&s=" + search + "&d=" + done + "&a=" + asc + "&i=" + important + "&wid=" + weddingId, true);
        xmlhttp.send();
    }

    function setDone(item) {
        var id = item.id.replaceAll("done_", "");
        var done = item.value;
        if (done == 0) {
            done = 1;
        } else {
            done = 0;
        }
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                var item = document.getElementById("done_" + id);
                if (this.responseText.includes("check")) {
                    item.value = 1;
                } else {
                    item.value = 0;
                }
                item.innerHTML = this.responseText;
            }
        }
        xmlhttp.open("GET", "functions/updateDone.php?id=" + id + "&done=" + done, true);
        xmlhttp.send();
    }

    function createTask() {
        var item = document.getElementById("create_task");
        if (item.className === "hide") {
            item.className = "";
        } else {
            item.className = "hide";
        }
    }

    function changeToDate(item) {
        var save = document.getElementById("save_" + item.id.split("_")[1]);
        save.className = "";
        var newItem = document.createElement("input");
        newItem.type = "date";
        newItem.id = item.id;
        newItem.value = item.innerText.split(".")[2] + "-" + item.innerText.split(".")[1] + "-" + item.innerText.split(".")[0];
        newItem.addEventListener("keyup", function (event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                //document.getElementById("myBtn").click();
                alert(newItem.value);
            }
        });
        item.parentNode.replaceChild(newItem, item);
    }

    function changeToText(item) {
        var save = document.getElementById("save_" + item.id.split("_")[1]);
        save.className = "";
        var newItem = document.createElement("input");
        newItem.type = "text";
        newItem.id = item.id;
        newItem.value = item.innerText;
        newItem.addEventListener("keyup", function (event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                alert(newItem.value);
            }
        });
        item.parentNode.replaceChild(newItem, item);
    }

    function deleteTask(item) {
        var id = item.id.replaceAll("delete_", "");
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                showChecklist();
            }
        }
        xmlhttp.open("GET", "functions/deleteTask.php?id=" + id, true);
        xmlhttp.send();
    }

    function save(item) {
        var parent = item.parentNode;
        var id = parent.id.replaceAll("save_", "");
        var itemTitle = document.getElementById("title_" + id);
        var title;
        if (itemTitle.tagName == "BUTTON") {
            title = itemTitle.innerText;
        } else {
            title = itemTitle.value;
        }
        var itemNote = document.getElementById("note_" + id);
        var note;
        if (itemNote.tagName == "BUTTON") {
            note = itemNote.innerText;
        } else {
            note = itemNote.value;
        }
        var date;
        var itemDate = document.getElementById("deadline_" + id);
        if (itemDate.tagName == "BUTTON") {
            date = itemDate.innerText;
        } else {
            date = itemDate.value;
        }
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var task = document.getElementById("task_" + id);
                task.innerHTML = this.responseText;
            }
        }
        xmlhttp.open("GET", "functions/updateTask.php?id=" + id + "&title=" + title + "&note=" + note + "&date=" + date, true);
        xmlhttp.send();
    }

</script>
</body>
</html>