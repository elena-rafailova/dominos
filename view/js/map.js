var map;


// function getLocation() {
//     navigator.geolocation.getCurrentPosition(initMap);
//
// }

function initMap(selected, allRestaurants) {
    myPos = {lat: selected.latitude, lng: selected.longitude};

    map = new google.maps.Map(document.getElementById('map'), {

        lat: selected.latitude,
        lng: selected.longitude,
        center: myPos,
        zoom: 16
    });


    infoWindow = new google.maps.InfoWindow;
    infoWindow.open(map);

    for (var key in allRestaurants) {
        (function () {
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(allRestaurants[key].latitude, allRestaurants[key].longitude),
                map: map,
                optimized: false,
                icon: 'https://www.dominos.bg/echo/images/dominos30.png',
            });
            var label = {color: '#333', fontWeight: 'bold', fontSize: '16px', text: allRestaurants[key].name};
            marker.setLabel(label);

            var info = document.createElement("div");
            var text = document.createElement("p");
            var phone = document.createElement("p");
            var bold = document.createElement("strong");
            bold.innerText = allRestaurants[key].name;
            text.innerText = allRestaurants[key].street_name + " " + allRestaurants[key].street_number;
            phone.innerText = "phone: " + allRestaurants[key].phone_number;

            info.appendChild(bold);
            info.appendChild(text);
            info.appendChild(phone);

            marker.addListener('click', function () {
                infoWindow.setContent(info);
                infoWindow.open(map, marker);
            });

        })();
    }
}

function getRestaurants() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var select = document.getElementById("restaurants");
            var data = this.responseText;
            data = JSON.parse(data);
            var allRestaurants = [];
            var selected;
            Array.prototype.forEach.call(data, function (data) {

                var restaurant = {
                    "id" : data.id,
                    "name" : data.name,
                    "street_name" : data.street_name,
                    "street_number" : data.street_number,
                    "phone_number" : data.phone_number,
                    "latitude" : parseFloat(data.latitude),
                    "longitude" : parseFloat(data.longitude)
                };

                allRestaurants.push(restaurant);

                var option = document.createElement("option");
                option.value = data.id;
                option.innerText = data.name;
                if (data.name === "SOFIA - STUDENT CITY") {
                    option.selected = true;
                    //const center = new google.maps.LatLng(, );
                    selected = {
                        "latitude" : parseFloat(data.latitude),
                        "longitude" : parseFloat(data.longitude)
                    };
                }
                //works only on Mozilla
                // option.addEventListener("click", function () {
                //         //alert("hi");
                //         selected = {
                //             "latitude": parseFloat(data.latitude),
                //             "longitude": parseFloat(data.longitude)
                //         };
                //         initMap(selected, allRestaurants);
                //
                // });
                //console.log(data.name);
                select.appendChild(option);
            });
            initMap(selected, allRestaurants);

            select.addEventListener("change", function () {
                for(var key in allRestaurants) {
                    if (allRestaurants[key].id == this.value) {
                        var current = {
                            "latitude": parseFloat(allRestaurants[key].latitude),
                            "longitude": parseFloat(allRestaurants[key].longitude)
                        };
                        initMap(current, allRestaurants);
                        break;
                    }
                }
            });
        }
    };
    xhttp.open("GET", "index.php?target=restaurant&action=getRestaurants", true);
    xhttp.send();
}

function getAddresses() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var select = document.getElementById("addresses");
            var data = this.responseText;
            data = JSON.parse(data);

            Array.prototype.forEach.call(data, function (data) {
                var option = document.createElement("option");
                option.value = data.id;
                option.innerText = data.name + " (" + data.street_name + " " + data.street_number + ")";
                select.appendChild(option);
            });
        }
    };
    xhttp.open("GET", "index.php?target=address&action=getAddresses", true);
    xhttp.send();
}

function seeAddresses() {
    //delivery.style.display = "block";
    //deliveryPopUp.style.display = "none";
}

function seeRestaurants() {
    //carryOut.style.display = "block";
    //deliveryPopUp.style.display = "none";
    //document.getElementById("map").style.display = "block";
}

function carryOutF() {
    var xhttp = new XMLHttpRequest();
    var select = document.getElementById("restaurants");
    var selectedRes = select.options[select.selectedIndex].value;
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("alert_if_delivery_empty").style.display = "none";
            //carryOut.style.display = "none";
        }
    };
    xhttp.open("POST", "index.php?target=user&action=deliveryMethod", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("resId=" + selectedRes);
}

function deliveryF() {
    var xhttp = new XMLHttpRequest();
    var select = document.getElementById("addresses");
    var selectedRes = select.options[select.selectedIndex].value;
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("alert_if_delivery_empty").style.display = "none";
            //document.getElementById("delivery").style.display = "none";
        }
    };
    xhttp.open("POST", "index.php?target=user&action=deliveryMethod", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("addrId=" + selectedRes);
}