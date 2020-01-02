var map;
var restaurants;

function createRestaurantDiv() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            restaurants = JSON.parse(this.responseText);
            var data = document.getElementById("data");
            data.innerText = this.responseText;
            data.style.display = "none";
        }
    };
    xhttp.open("GET", "index.php?target=restaurant&action=getRestaurants", true);
    xhttp.send();
}


function getLocation() {
    navigator.geolocation.getCurrentPosition(initMap);

}

function initMap(position) {
    var myPos = {lat: position.coords.latitude, lng: position.coords.longitude};
    map = new google.maps.Map(document.getElementById('map'), {

        lat: position.coords.latitude,
        lng: position.coords.longitude,
        center: myPos,
        zoom: 20
    });


    infoWindow = new google.maps.InfoWindow;
    infoWindow.setContent('You are here.');
    infoWindow.setPosition(myPos);
    infoWindow.open(map);


    var markerOptions = new google.maps.Marker({
        clickable: true,
        flat: true,
        map: map,
        position: myPos,
        title: "You are here",
        visible:true,
        icon:'http://maps.google.com/mapfiles/ms/icons/blue-dot.png',
    });

    var data = document.getElementById("data").innerText;
    data = JSON.parse(data);

    Array.prototype.forEach.call(data, function (data){
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(parseFloat(data.latitude), parseFloat(data.longitude)),
            map: map,
            optimized: false,
            icon:'https://www.dominos.bg/echo/images/dominos30.png',
        });
        var label = { color: '#333', fontWeight: 'bold', fontSize: '16px', text: data.name };
        marker.setLabel(label);

        var info = document.createElement("div");
        var text = document.createElement("p");
        var bold = document.createElement("strong");
        bold.innerText = data.name;
        text.innerText = data.street_name + " " + data.street_number;

        info.appendChild(bold);
        info.appendChild(text);

        marker.addListener('click', function() {
            infoWindow.setContent(info);
            infoWindow.open(map, marker);
        });

    });
}