<?php
include_once "main.php";

//if (!isset($restaurants)) {
//    header("index.php?target=restaurant&action=show");
//}
?>

<body onload="getRestaurants()">
<div id="data"></div>
<table id="restaurants">
    <tr>
        <th>Phone number:</th>
        <th>Name:</th>
        <th>Address:</th>
        <th>Number:</th>
    </tr>
</table>

<div id="map"></div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNlaNlS38FSY8XNxzvEuw7mt-1WsrlspM&callback=getLocation"
        async defer></script>

</body>

<script>
    var map;
    var restaurants;
    var geocoder;

    function getRestaurants() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                restaurants = JSON.parse(this.responseText);
                var data = document.getElementById("data");
                data.innerText = this.responseText;
                data.style.display = "none";
                var table = document.getElementById("restaurants");
                for (var key in restaurants) {
                    var tr = document.createElement("tr");
                    for (var field in restaurants[key]) {
                        if (field == "id" || field == "city_id" || field == "latitude" || field == "longitude") {
                             continue
                        }
                        var td = document.createElement("td");
                        td.innerText = restaurants[key][field];
                        var br = document.createElement("br");

                        tr.appendChild(td);
                    }
                    table.appendChild(tr)
                }
            }
        };
        xhttp.open("GET", "index.php?target=restaurant&action=getRestaurants", true);
        xhttp.send();
    }


    function getLocation() {
        var options = {
            enableHighAccuracy: true,
            timeout: 5000,
            maximumAge: 0
        };

        navigator.geolocation.getCurrentPosition(initMap, null, options);

    }

    function initMap(position) {
        var myPos = {lat: position.coords.latitude, lng: position.coords.longitude};
        map = new google.maps.Map(document.getElementById('map'), {

            lat: position.coords.latitude,
            lng: position.coords.longitude,
            center: myPos,
            zoom: 20
        });


        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(parseFloat(position.coords.latitude), parseFloat(position.coords.longitude)),
            map: map,
            optimized: false,
            title: "Home"

        });

        var data = document.getElementById("data").innerText;
        data = JSON.parse(data);

        Array.prototype.forEach.call(data, function (data){
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(parseFloat(data.latitude), parseFloat(data.longitude)),
                map: map,
                optimized: false,
                title: data.name

            });
            var label = { color: '#333', fontWeight: 'bold', fontSize: '16px', text: data.name };
            marker.setLabel(label);
        });
    }
</script>


