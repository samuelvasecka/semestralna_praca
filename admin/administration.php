<?php
require_once "../objects/Country.php";
require_once "../objects/Location.php";
require_once "../objects/Cookies.php";
require_once "../objects/Commission.php";
require_once "../objects/Admin.php";


$location = new Location();

if (isset($_POST["logout"])) {
    Admin::logout();
    header('Location: ../home.php');
    exit();
}

$location->redirect("admin/administration.php");
$commissions = Commission::getCommissions();

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
        <span class="title">Admin panel</span>
        <form method="POST" class="login">
            <button type="submit" name="logout" class="button">Logout</button>
        </form>
    </div>
    <div id="commissions_table">
        <table >
            <tr>
                <th>Username</th>
                <th>Country</th>
                <th>Confirmed</th>
            </tr>
            <?php
            foreach ($commissions as $commission) {
                ?>
                <tr>
                    <td><?php echo $commission->getUsername();?></td>
                    <td><?php echo $commission->getCountryName();?></td>
                    <td><?php if($commission->getConfirmed() == 1) {
                            echo '<input type="checkbox" onclick="confirmCommission('.$commission->getId().','.$commission->getConfirmed().')" name="confirmed" checked/>';
                        } else {
                            echo '<input type="checkbox" onclick="confirmCommission('.$commission->getId().','.$commission->getConfirmed().')" name="confirmed" />';
                        }?></td>
                </tr>
                <?php
            }
            ?>
        </table>

    </div>

</div>
<script>
    function confirmCommission(id, confirmed) {
        var xmlHttp = new XMLHttpRequest();
        xmlHttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("commissions_table").innerHTML = this.responseText;
            }
        }
        xmlHttp.open("GET", "../ajaxCalls/getCommissions.php?id=" + id +"&confirmed="+confirmed, true);
        xmlHttp.send();
    }
</script>
</body>
</html>
