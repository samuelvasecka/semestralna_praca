<?php
require_once "objects/Location.php";
require_once "objects/Commission.php";
require_once "objects/Country.php";
require_once "objects/Results.php";

$location = new Location();
$location->redirect("home.php");

$countries = Country::getCountries();
$candidates = Country::getResults(0);
$candidates = Results::createResults($candidates);
$candidatesVotes = Country::getElectoralResults();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
          integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
          crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
            integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
            crossorigin=""></script>
    <style>


    </style>

</head>
<body>
<div class="container">
    <div class="menu">
        <span class="title">American election</span>
        <form action="commission/login.php" class="login">
            <button class="button">Login</button>
        </form>
    </div>
    <select id="countries_select" onchange="getResults(this.value)">
        <option value="0">USA</option>
        <?php
        foreach ($countries as $country) {
            ?>
            <option value="<?php echo $country->id; ?>"><?php echo $country->name; ?></option><?php
        }
        ?>
    </select>
    <div id="mapid" class="space"></div>


    <div id="results">
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

</div>
<script>

    var mymap = L.map('mapid').setView([40.178873, -99.965756], 4);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        maxZoom: 18,
        minZoom: 2,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
    }).addTo(mymap);



    function foundName(name) {
        var countries = document.getElementById("countries_select").childNodes;
        for (var i = 0; i < countries.length; i++) {
            if (name == countries[i].innerText) {
                return true;
            }
        }
        return false;
    }

    var polys, parser, xmlDoc, latCenter, longCenter;
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open("GET", "polygons/states.xml", true);
    xmlHttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            parser = new DOMParser();
            xmlDoc = parser.parseFromString(this.responseText, "text/xml");
            var states = xmlDoc.getElementsByTagName("state");
            polys = [states.length];
            latCenter = [states.length];
            longCenter = [states.length];
            for (var a = 0; a < states.length; a++) {
                var name = states[a].getAttribute("name");
                if (foundName(name)) {
                    var points = states[a].getElementsByTagName("point");
                    var pts = [points.length];
                    latCenter[a] = 0;
                    longCenter[a] = 0;
                    for (var i = 0; i < points.length; i++) {
                        pts[i] = [parseFloat(points[i].getAttribute("lat")),
                            parseFloat(points[i].getAttribute("lng"))];
                        latCenter[a] += pts[i][0];
                        longCenter[a] += pts[i][1];
                    }
                    latCenter[a] = latCenter[a] / points.length;
                    longCenter[a] = longCenter[a] / points.length;
                    var polygon = L.polygon(pts).addTo(mymap);
                    polygon.setStyle({
                        "color":"#b7163a"
                    });
                    polygon.bindPopup(name);
                    polygon.on("mouseover", function (e) {
                        this.openPopup();
                    });
                    polygon.on("mouseout", function (e) {
                        this.closePopup();
                    });
                    polys[a] = polygon;
                }
            }
            polys.forEach(addFunction);
        }
    };
    xmlHttp.send();

    function addFunction(item, index) {
        item.on("click", function (e) {
            this.closePopup();
            getResults(index + 1);
        });
        item.on("mouseover", function (e) {
            this.setStyle({
               "color":"#1d2041"
            });
        });
        item.on("mouseout", function (e) {
            this.setStyle({
                "color":"#b7163a"
            });
        });
    }

    function getResults(country_id) {

        document.getElementById('countries_select').value=(country_id);
        var xmlHttp = new XMLHttpRequest();
        xmlHttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("results").innerHTML = this.responseText;
            }
        }
        xmlHttp.open("GET", "ajaxCalls/getResults.php?country_id=" + country_id, true);
        xmlHttp.send();
        if (country_id != 0) {
            mymap.flyTo([latCenter[country_id - 1], longCenter[country_id - 1]], 5);
        } else {
            mymap.flyTo([40.178873, -99.965756], 4);
        }
    }
</script>
</body>
</html>