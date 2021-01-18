<?php
require_once "../objects/Commission.php";
require_once "../objects/Location.php";

$location = new Location();
$location->redirect("country/history.php");

$commission = Commission::getCommission();
$history = $commission->getHistory();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>History</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
<div class="container">
    <div class="menu">
        <span class="title"><?php echo $commission->getCountryName();?> history</span>
        <form action="administration.php" class="login">
            <button class="button">Administration</button>
        </form>
    </div>
    <table>
        <tr>
            <th>Commission</th>
            <th>Time</th>
            <?php
            if (count($history) > 0) {
                foreach ($history[0]->candidates as $candidate) {
                    echo "<th>".json_decode($candidate)->name."</th>";
                }
            }
            ?>
        </tr>
        <?php
        foreach ($history as $record) {
            echo "<tr><td>".$record->username."</td>";
            $date = strtotime( $record->created );
            echo "<td>".date( 'H:i:s - d.m.Y', $date )."</td>";
            foreach ($record->candidates as $candidate) {
                echo "<td>".json_decode($candidate)->votes."</td>";
            }
            echo "</tr>";
        }
        ?>
    </table>
</div>
</body>
</html>