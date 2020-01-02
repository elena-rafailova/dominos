function getPizzas(category) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var table = document.getElementById("pizzas");
            table.innerHTML = "";
            var pizzas = this.responseText;
            pizzas = JSON.parse(pizzas);
            //alert(pizzas)

            for (var key in pizzas) {
                //alert(pizzas[key]["ingredients"]);
                var tr = document.createElement("tr");
                var td = document.createElement("td");
                var br = document.createElement("br");

                var img = document.createElement("img");
                img.src = pizzas[key]["img_url"];
                td.appendChild(img);

                var str = [];
                for (var ingr in pizzas[key]["ingredients"]) {
                    str[ingr] = pizzas[key]["ingredients"][ingr]["name"];
                }

                var p1 = document.createElement("p");
                p1.innerText = pizzas[key]["name"];

                var p2 = document.createElement("p");
                p2.innerText = str.join(", ");
                td.appendChild(p1);
                td.appendChild(p2);

                var form = document.createElement("form");
                form.action = "index.php?target=pizza&action=showPizza";
                form.method = "post";
                var input1 = document.createElement("input");
                input1.type = "hidden";
                input1.value = pizzas[key]["id"];
                input1.name = "id";

                form.appendChild(input1);

                var input2 = document.createElement("input");
                input2.type = "submit";
                input2.value = "Choose";
                input2.name = "choose";

                form.appendChild(input2);

                td.appendChild(form);

                tr.appendChild(td);
                table.appendChild(tr);
            }
        }
    };

    xhttp.open("GET", "index.php?target=pizza&action=getPizzasInfo&category=" + category, true);
    xhttp.send();
}

function getRestaurants() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var select = document.getElementById("restaurants");
            var data = this.responseText;
            data = JSON.parse(data);

            Array.prototype.forEach.call(data, function (data) {
                var option = document.createElement("option");
                option.value = data.id;
                option.innerText = data.name;
                select.appendChild(option);
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
    delivery.style.display = "block";
    deliveryPopUp.style.display = "none";
}

function seeRestaurants() {
    carryOut.style.display = "block";
    deliveryPopUp.style.display = "none";
    document.getElementById("map").style.display = "block";
}

function carryOutF() {
    var xhttp = new XMLHttpRequest();
    var select = document.getElementById("restaurants");
    var selectedRes = select.options[select.selectedIndex].value;
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            carryOut.style.display = "none";
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
            delivery.style.display = "none";
        }
    };
    xhttp.open("POST", "index.php?target=user&action=deliveryMethod", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("addrId=" + selectedRes);
}

// function getTimes() {
//     var del_time = document.getElementById("del-time");
//     var pick_up = document.getElementById("pick-up-time");
//     var today = new Date();
//     var time = today.getHours() + ":" + today.getMinutes();
//
//     var add_minutes =  function (dt, minutes) {
//         return new Date(dt.getTime() + minutes*60000);
//     };
//     var newDateObj = new Date(today.getTime());
//     while(time <= "23:40") {
//         newDateObj = new Date(newDateObj.getTime() + 10*60000);
//         time = newDateObj.getHours() + ":" + ((newDateObj.getMinutes() < 10) ? "0" : "") + newDateObj.getMinutes();
//         var option = document.createElement("option");
//         option.innerText = time;
//         del_time.appendChild(option);
//         pick_up.appendChild(option);
//     }
// }