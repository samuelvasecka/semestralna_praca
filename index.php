<?php
include "../semestralna_praca/php/common/database.php";
$cookie_name = "user_id";

if (!isset($_COOKIE[$cookie_name])) {

    echo '<script type="text/javascript">
           window.location = "login.php"
      </script>';

} else {
    if ($_COOKIE[$cookie_name] == -1) {
        echo '<script type="text/javascript">
           window.location = "login.php"
      </script>';
    }
}

if (isset($_POST['upload'])) {
    $image = $_FILES['image']['name'];
    $image = "images/post/".$image;
    $title = $_POST["title"];
    $desc = $_POST["desc"];
    $page = $_GET["p"];
    $target = "images/post/" . basename($image);
    $conn = getConnection();
    if ($conn == null) {
    } else {
        $sql = "INSERT INTO post(id_user, title, description, image, page, created) VALUES (" . $_COOKIE["user_id"] . ", '" . $title . "', '" . $desc . "', '" . $image . "', " . $page . ", now())";
        $result = $conn->query($sql);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $msg = "Image uploaded successfully";
        } else {
            $msg = "Failed to upload image";
        }
    }
}

if (isset($_GET["p"])) {
    $conn = getConnection();
    if ($conn == null) {

    } else {
        if ($_GET["p"] != 0) {
            $sql = "SELECT id FROM page WHERE id=" . $_GET["p"];
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {

            } else {
                echo '<script type="text/javascript">
           window.location = "index.php"
            </script>';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../semestralna_praca/styles/styleHome.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../semestralna_praca/images/logo-new-small.png">
</head>
<body>
<div class="header" id="myTopnav">
    <div class="logo">
        <img alt="logo" src="../semestralna_praca/images/logo-new-small.png" height="44"/>
    </div>

    <div class="search-container">
        <form>
            <input type="text" onkeyup="showResult(this.value)" placeholder="Search">
        </form>
        <div class="dropdown">
            <button class="dropbtn-search" onclick="rollSearch()">
                <span id="search-type">All</span>
                <i class="fa fa-caret-down" id="dropdown-icon-search"></i>
            </button>
        </div>
    </div>
    <div class="dropdown-content" id="dropdown-content-search">
        <a onclick="changeSearchType(1)">All</a>
        <a onclick="changeSearchType(2)">Pages</a>
        <a onclick="changeSearchType(3)">Users</a>
        <a onclick="changeSearchType(4)">Posts</a>
    </div>
    <div id="livesearch">

    </div>
    <div class="dropdown">
        <button class="dropbtn" onclick="rollMenu()">
            <i class="fa fa-bars" id="dropdown-icon"></i>
        </button>
        <div class="dropdown-content" id="dropdown-content">
            <a href="#">Profile</a>
            <a href="#">Admin</a>
            <a href="#">Home</a>
            <hr>
            <a href="#">My posts</a>
            <a href="#">Follow</a>
            <a href="index.php?p=0">All</a>
            <hr>
            <a href="#">Top</a>
            <a href="#">Login</a>
            <a href="../semestralna_praca/login.php" onclick="setCookie()">Logout</a>
        </div>
    </div>
</div>

<div class="redCon2">
    <div class="con1">
        <div>
            <div class="filter">
                <button class="dropbtn-filter" id="dropbtn-new" onclick="rollNew()">
                    <span id="new-type">New At</span>
                    <i class="fa fa-caret-down" id="dropdown-icon-new"></i>
                </button>
                <div class="dropdown-content" id="dropdown-content-new">
                    <a onclick="changeNewType(1)">1 day</a>
                    <a onclick="changeNewType(2)">1 week</a>
                    <a onclick="changeNewType(3)">1 month</a>
                    <a onclick="changeNewType(4)">All time</a>
                </div>
                <button class="dropbtn-filter" id="dropbtn-top" onclick="rollTop()">
                    <span id="top-type">Dis</span>
                    <i class="fa fa-caret-down" id="dropdown-icon-top"></i>

                </button>
                <div class="dropdown-content" id="dropdown-content-top">
                    <a onclick="changeTopType(1)">Top likes</a>
                    <a onclick="changeTopType(2)">Top comment</a>
                    <a onclick="changeTopType(3)">Disable</a>
                </div>
                <button class="dropbtn-filter" id="dropbtn-my" onclick="activeMy()">
                    <span id="my-type">My posts</span>
                </button>
            </div>
            <div id="add-post">

            </div>
            <div id="item">

            </div>

        </div>
    </div>
    <div class="con2" id="con2">
        <div class="content" id="content">
            <div>
                <?php
                for ($i = 0; $i < 100; $i++) {
                    echo "<div>$i</div>";
                }
                ?>
            </div>
            <a href="#myTopnav">Go up</a>
        </div>
    </div>
</div>


<script>
    $(window).bind('scroll', function () {
        var windowScrollHeight = $(window).scrollTop()
        var scrollPlusWindowHeight = windowScrollHeight + $(window).height();
        var fixedContentHeight = $(".content").height();
        var contentHeight = $(".con1").height();

        if (contentHeight > fixedContentHeight) {
            if (scrollPlusWindowHeight > (fixedContentHeight + 40)) {
                $(".content").addClass("fixed-bottom");
            } else {
                $(".content").removeClass("fixed-bottom");
            }
        }

    });

    function getProfile() {

    }

    function logOut() {

    }

    function getMyAdmin() {

    }

    function changeSearchType(type) {
        switch (type) {
            case 1:
                document.getElementById("search-type").innerHTML = "All";
                break;
            case 2:
                document.getElementById("search-type").innerHTML = "Pages";
                break;
            case 3:
                document.getElementById("search-type").innerHTML = "Users";
                break;
            case 4:
                document.getElementById("search-type").innerHTML = "Posts";
                break;
            default:
                document.getElementById("search-type").innerHTML = "All";
                break;
        }
        rollSearch();

    }

    function changeNewType(type) {
        var x = document.getElementById("dropbtn-new")
        switch (type) {
            case 1:
                document.getElementById("new-type").innerHTML = "New 1d";
                if (x.className === "dropbtn-filter") {
                    x.className += " active-button";
                }

                break;
            case 2:
                document.getElementById("new-type").innerHTML = "New 1w";
                if (x.className === "dropbtn-filter") {
                    x.className += " active-button";
                }
                break;
            case 3:
                document.getElementById("new-type").innerHTML = "New 1m";
                if (x.className === "dropbtn-filter") {
                    x.className += " active-button";
                }
                break;
            case 4:
                document.getElementById("new-type").innerHTML = "New At";
                x.className = "dropbtn-filter";
                break;
            default:
                document.getElementById("new-type").innerHTML = "New At";
                x.className = "dropbtn-filter";
                break;
        }
        rollNew();
        showItems();
    }

    function changeTopType(type) {
        var x = document.getElementById("dropbtn-top")
        switch (type) {
            case 1:
                document.getElementById("top-type").innerHTML = "Top l";
                if (x.className === "dropbtn-filter") {
                    x.className += " active-button";
                }

                break;
            case 2:
                document.getElementById("top-type").innerHTML = "Top c";
                if (x.className === "dropbtn-filter") {
                    x.className += " active-button";
                }
                break;
            case 3:
                document.getElementById("top-type").innerHTML = "Dis";
                x.className = "dropbtn-filter";
                break;
            default:
                document.getElementById("top-type").innerHTML = "Dis";
                x.className = "dropbtn-filter";
                break;
        }
        rollTop();
        showItems();
    }

    function hideCon2() {
        // funkcia na schovanie bocneho panelu... v nastaveniach sa bude dat zmenit (bude treba si to zapamatat)
        var x = document.getElementById("con2");
        if (x.className === "con2") {
            $(".con2").addClass("display-none");
            document.getElementById("show-topper").innerHTML = "Show topper";
        } else {
            $(".con2").removeClass("display-none");
            document.getElementById("show-topper").innerHTML = "Hide topper";
        }

    }

    $(document).ready(
        showAddPost()
    );

    function showAddPost() {
        var page = <?php if (!isset($_GET["p"])) {
            echo 0;
        } else {
            echo $_GET["p"];
        } ?>;
        if (page != 0) {
            var html =
                `<div class="item">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="add-post-title">
                        <input type="text" placeholder="Enter title" name="title" required />
                        </div>
                        <div class="add-post-desc">
                            <textarea placeholder="Enter Description" name="desc" required></textarea>
                        </div>
                        <div class="add-post-upload">
                            <input type="file" name="image">
                        </div>
                        <button type="submit" name="upload" class="dropbtn-publish" onclick="">
                            Publish post
                        </button>
                    </form>
                </div>`;
            document.getElementById("add-post").innerHTML = html;
        } else {
            document.getElementById("add-post").innerHTML = "";
        }
    }

    function rollMenu() {
        var x = document.getElementById("dropdown-icon");
        var y = document.getElementById("dropdown-content");
        if (x.className === "fa fa-bars") {
            x.className = "fa fa-close";
            y.className += " roll"
        } else {
            x.className = "fa fa-bars";
            y.className = "dropdown-content";
        }
    }

    function rollSearch() {
        var x = document.getElementById("dropdown-icon-search");
        var y = document.getElementById("dropdown-content-search");
        if (x.className === "fa fa-caret-down") {
            x.className = "fa fa-caret-up";
            y.className += " roll"
        } else {
            x.className = "fa fa-caret-down";
            y.className = "dropdown-content";
        }
    }

    function rollNew() {
        var x = document.getElementById("dropdown-icon-new");
        var y = document.getElementById("dropdown-content-new");
        if (x.className === "fa fa-caret-down") {
            x.className = "fa fa-caret-up";
            y.className += " roll"
        } else {
            x.className = "fa fa-caret-down";
            y.className = "dropdown-content";
        }
    }

    function rollTop() {
        var x = document.getElementById("dropdown-icon-top");
        var y = document.getElementById("dropdown-content-top");
        if (x.className === "fa fa-caret-down") {
            x.className = "fa fa-caret-up";
            y.className += " roll"
        } else {
            x.className = "fa fa-caret-down";
            y.className = "dropdown-content";
        }
    }

    function activeMy() {
        var x = document.getElementById("dropbtn-my");
        if (x.className === "dropbtn-filter") {
            x.className += " active-button";
        } else {
            x.className = "dropbtn-filter";
        }
        showItems();
    }

    function showResult(str) {
        if (str.length == 0) {
            document.getElementById("livesearch").innerHTML = "";
            document.getElementById("livesearch").style.border = "0px";
            return;
        }

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("livesearch").innerHTML = this.responseText;
                document.getElementById("livesearch").style.border = "1px solid #A5ACB2";
            }
        }
        var type = document.getElementById("search-type").innerText.toLowerCase();
        xmlhttp.open("GET", "http://localhost/semestralna_praca/php/functions/livesearch.php?q=" + str + "&t=" + type, true);
        xmlhttp.send();
    }

    $(document).ready(showItems());
    $(document).change(showItems());

    function showItems() {
        var newFilter;
        switch (document.getElementById("new-type").innerText) {
            case "New 1d":
                newFilter = 1;
                break;
            case "New 1w":
                newFilter = 2;
                break;
            case "New 1m":
                newFilter = 3;
                break;
            default:
                newFilter = 4;
                break;
        }
        var top;
        switch (document.getElementById("top-type").innerText) {
            case "Top l":
                top = 1;
                break;
            case "Top c":
                top = 2;
                break;
            default:
                top = 3;
                break;
        }
        var my;
        if (document.getElementById("dropbtn-my").className === "dropbtn-filter") {
            my = 0;
        } else {
            my = 1;
        }
        var page = <?php if (!isset($_GET["p"])) {
            echo 0;
        } else {
            echo $_GET["p"];
        } ?>;

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("item").innerHTML = this.responseText;
            }
        }
        xmlhttp.open("GET", "http://localhost/semestralna_praca/php/functions/posts.php?n=" + newFilter + "&t=" + top + "&m=" + my + "&p=" + page, true);
        xmlhttp.send();
    }

    function setCookie() {
        var exdate = new Date()
        document.cookie = "user_id=-1;expires=-1";
    }
</script>
</body>
</html>