<?php
require_once "../objects/Country.php";
require_once "../objects/Results.php";

if (isset($_GET["country_id"])) {
    $countryId = $_GET["country_id"];

    $candidates = Country::getResults($countryId);
    $candidates = Results::createResults($candidates);
    $candidatesVotes = Country::getElectoralResults();

    $response = '<table >
    <tr>
        <th>Candidate</th>
        <th>Party</th>
        <th>Votes</th>
        <th>Percentage</th>';

    if ($countryId == 0) {
        $response.="<th>Electoral votes</th>";
    }

    $response.='</tr>';

    $i = 0;
    foreach ($candidates as $candidate) {
        $response .= "<tr><td>" . $candidate->name . "</td>";
        $response .= "<td>" . $candidate->party . "</td>";
        $response .= "<td>" . $candidate->votes . "</td>";
        $response .= "<td>" . $candidate->percentage . "%</td>";
        if ($countryId == 0) {
            $response .= "<td>". $candidatesVotes[$i]->electoral_votes."</td></tr>";
        } else {
            $response .= "</tr>";
        }

        $i++;
    }
    $response.= "</table>";



    echo $response;


}