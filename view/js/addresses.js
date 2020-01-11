

function viewAddresses() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var addresses_body = document.getElementById("addresses");
            addresses_body.innerHTML = "";
            var addresses = this.responseText;
            addresses = JSON.parse(addresses);

            var my_addresses = document.createElement("div");


            var p = document.createElement("p");
            p.innerHTML = "My addresses";
            p.setAttribute("class", "font-weight-bold text-center");
            my_addresses.appendChild(p);

            var ul = document.createElement("ul");
            ul.setAttribute("class", "list-group");

            if (addresses === false) {
                var li = document.createElement("li");
                li.setAttribute("class", "list-group-item list-group-item-action w-55 p-1 ");
                li.innerHTML = "You've no addresses yet. <br> Please add new address.";
                ul.appendChild(li);
            } else {
                for (var key in addresses) {
                    var li1 = document.createElement("li");
                    li1.setAttribute("class", "list-group-item list-group-item-action w-55 p-1");
                    var a = document.createElement("a");
                    a.href = 'index.php?target=address&action=show&id=' + addresses[key].id;
                    a.innerHTML = addresses[key].name;
                    li1.appendChild(a);
                    ul.appendChild(li1);
                }
            }
            my_addresses.appendChild(ul);


            var add_address = document.createElement("button");
            add_address.setAttribute("class", "btn" );
            add_address.onclick = function () {
                location.href = 'index.php?target=address&action=add';
            };
            var i= document.createElement("i");
            i.setAttribute("class","fas fa-plus");
            var span = document.createElement("span");
            span.innerHTML = "  Add a new address <br>";
            span.setAttribute("class", "font-weight-bold text-center")

           add_address.appendChild(i);
            i.appendChild(span);




            addresses_body.appendChild(my_addresses);
            addresses_body.appendChild(add_address);

            var url = window.location.search.substr(1);
            url = url.split("&");
            url = url[url.length - 1];
            var id = url.split("=");
            var addressId = id[id.length - 1];
            if (addresses !== false) {
                for (var key in addresses) {
                    if (addresses[key].id === addressId) {
                        var address_name = document.getElementById("address_name");
                        address_name.value = addresses[key].name;
                        var street_name = document.getElementById("street_name");
                        street_name.value = addresses[key].street_name;
                        var street_number = document.getElementById("street_number");
                        street_number.value = addresses[key].street_number;
                        var city = document.getElementById("city_select");
                        city.value = addresses[key].city_id;
                        city.innerHTML = addresses[key].city_name;
                        var phone_number = document.getElementById("phone_number");
                        phone_number.value = addresses[key].phone_number;
                        var floor = document.getElementById("floor");
                        floor.value = addresses[key].floor;
                        var building_number = document.getElementById("building_number");
                        building_number.value = addresses[key].building_number;
                        var apartment_number = document.getElementById("apartment_number");
                        apartment_number.value = addresses[key].apartment_number;
                        var entrance = document.getElementById("entrance");
                        entrance.value = addresses[key].entrance;
                        var address_id = document.getElementById("address_id");
                        address_id.value = addresses[key].id;

                        // var change = document.createElement("img");
                        // change.src = "uploads/green_check.svg";
                        // change.style.width = "30px";
                        // change.setAttribute("class", "icons");
                        // var change_div = document.getElementById("change");
                        // change_div.onsubmit = function () {
                        //     location.href = 'index.php?target=address&action=change';};
                        // change_div.appendChild(change);
                        //
                        // var delete_icon = document.createElement("img");
                        // delete_icon.src = "uploads/delete_cross.svg";
                        // delete_icon.style.width = "30px";
                        // delete_icon.setAttribute("class", "icons");
                        // var delete_div = document.getElementById("delete");
                        // delete_div.onsubmit = function () {
                        //     location.href = 'index.php?target=address&action=delete';};
                        // delete_div.appendChild(delete_icon);
                    } else {
                        var address_name = document.getElementById("address_name");
                        address_name.value = addresses[0].name;
                        var street_name = document.getElementById("street_name");
                        street_name.value = addresses[0].street_name;
                        var street_number = document.getElementById("street_number");
                        street_number.value = addresses[0].street_number;
                        var city = document.getElementById("city_select");
                        city.value = addresses[0].city_id;
                        city.innerHTML = addresses[0].city_name;
                        var phone_number = document.getElementById("phone_number");
                        phone_number.value = addresses[0].phone_number;
                        var floor = document.getElementById("floor");
                        floor.value = addresses[0].floor;
                        var building_number = document.getElementById("building_number");
                        building_number.value = addresses[0].building_number;
                        var apartment_number = document.getElementById("apartment_number");
                        apartment_number.value = addresses[0].apartment_number;
                        var entrance = document.getElementById("entrance");
                        entrance.value = addresses[0].entrance;
                        var address_id = document.getElementById("address_id");
                        address_id.value = addresses[0].id;
                    }
                }
            }
        }
    };
    xhttp.open("GET", "index.php?target=address&action=getAddresses", true);
    xhttp.send();
}