<?php
require_once "../objects/Commission.php";

if (isset($_GET["id"]) && isset($_GET["confirmed"])) {
    $id = (int)$_GET["id"];
    $confirmed = (int)$_GET["confirmed"];

    Commission::changeConfirmed($id, $confirmed);
    $commissions = Commission::getCommissions();
    $response = '<table >
    <tr>
        <th>Username</th>
        <th>Country</th>
        <th>Confirmed</th>
    </tr>';

    foreach ($commissions as $commission) {
        $response .= "<tr><td>" . $commission->getUsername() . "</td>";
        $response .= "<td>" . $commission->getCountryName() . "</td><th>";
        if ($commission->getConfirmed() == 1) {
            $response .= '<input type="checkbox" onclick="confirmCommission(' . $commission->getId() . ',' . $commission->getConfirmed() . ')" name="confirmed" checked/>';
        } else {
            $response .= '<input type="checkbox" onclick="confirmCommission(' . $commission->getId() . ',' . $commission->getConfirmed() . ')" name="confirmed" />';
        }
        $response .= "</td></tr>";
    }
    $response.= "</table>";
    echo $response;
}
