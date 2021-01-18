<?php
require_once "../objects/Country.php";
require_once "../objects/Location.php";
require_once "../objects/Cookies.php";
require_once "../objects/Commission.php";
require_once "../objects/Results.php";



$location = new Location();


if (isset($_POST["logout"])) {
    Commission::logout();
    header('Location: ../home.php');
    exit();
}

$commission = Commission::getCommission();

$resAdd = 0;
if (isset($_POST["add_votes"])) {
    $resAdd = $commission->addVotes();
}

$res = 0;
if (isset($_POST["remove_votes"])) {
    $res = $commission->removeLastVotes();
}

$location->redirect("country/administration.php");
$countries = Country::getCountries();
$candidates = Country::getResults(1);
$candidates = Results::createResults($candidates);
$candidatesVotes = Country::getElectoralResults();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Administration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">

</head>
<body>
<div class="container">
    <div class="menu">
        <span class="title"><?php echo $commission->getCountryName();?></span>
        <form method="POST" class="login">
            <button type="submit" name="logout" class="button">Logout</button>
        </form>
    </div>
    <select onchange="getResults(this.value)">
        <option value="0">USA</option>
        <?php
        foreach ($countries as $country) {
            ?>
            <option value="<?php echo $country->id; ?>"><?php echo $country->name; ?></option><?php
        }
        ?>
    </select>
    <div id="results" class="space">
        <table>
            <tr>
                <th>Candidate</th>
                <th>Party</th>
                <th>Votes</th>
                <th>Percentage</th>
                <th>Electoral votes</th>
            </tr>
            <?php
            $i = 0;
            foreach ($candidates as $candidate) {
                echo "<tr><td>" . $candidate->name . "</td>";
                echo "<td>" . $candidate->party . "</td>";
                echo "<td>" . $candidate->votes . "</td>";
                echo "<td>" . $candidate->percentage . "%</td>";
                echo "<td>" . $candidatesVotes[$i]->electoral_votes . "</td></tr>";
                $i++;
            }
            ?>
        </table>
    </div>
    <button onclick="showAddVotes()" id="show_add_votes" class="login_button space">Add votes</button>
    <div id="add_votes" class="hide">
        <form method="POST">
            <?php
            foreach ($candidates as $candidate) {
                echo '<div class="space"><label>'.$candidate->name.'</label></div>';
                echo '<div class="space"><input type="number" name="votes[]" placeholder="Enter votes" required></div>';
            }
            ?>
            <button type="submit" class="login_button space" name="add_votes">Add votes</button>
        </form>
    </div>
    <?php
    if ($resAdd == 2) {
        echo "<div class='message'>You must fill in all data.</div>";
    } else if ($resAdd == 1) {
        echo "<div class='message space'>Votes were added.</div>";
    } else if ($resAdd == 4) {
        echo "<div class='message'>Connection problem. Please try again later.</div>";
    }
    ?>
    <form method="POST">
        <button type="submit" class="login_button space" name="remove_votes">Remove last votes</button>
    </form>
    <?php
    if ($res == 3) {
        echo "<div class='message space'>All your records are removed yet.</div>";
    } else if ($res == 1) {
        echo "<div class='message space'>Votes were removed.</div>";
    } else if ($resAdd == 4) {
        echo "<div class='message'>Connection problem. Please try again later.</div>";
    }
    ?>

    <form action="history.php">
        <button class="login_button space">Show history</button>
    </form>
</div>
<script>
    function getResults(country_id) {
        var xmlHttp = new XMLHttpRequest();
        xmlHttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("results").innerHTML = this.responseText;
            }
        }
        xmlHttp.open("GET", "../ajaxCalls/getResults.php?country_id=" + country_id, true);
        xmlHttp.send();
    }

    function showAddVotes() {
        var form = document.getElementById("add_votes");
        var item = document.getElementById("show_add_votes");
        if (form.className === "hide") {
            form.className = "";
            item.innerText = "Close";
        } else{
            form.className = "hide";
            item.innerText = "Add votes";
        }
    }
</script>
</body>
</html>
