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
                td.appendChild(p1);

                var p2 = document.createElement("p");
                p2.innerText = str.join(", ");
                td.appendChild(p2);

                var form = document.createElement("form");
                form.action = "index.php?target=pizza&action=show&id=" + pizzas[key]["id"];
                form.method = "post";


                var button = document.createElement("button");
                button.innerText = "Choose";
                form.appendChild(button);

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

var toppings;

function initializePizza() {
    getDoughs();
    getSizes();
    getPizza();
    getSauces();
    var i;
    for (i = 2; i <= 6; i++) {
        getIngr(i);
    }

    var price_for_one = document.getElementById("price-for-one");
    price_for_one.style.display = "none";

    var customize = document.getElementById("customize");
    customize.style.display = "none";

}


function getDoughs() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var doughs = document.getElementById("doughs");
            var list = JSON.parse(this.responseText);
            for (var key in list) {
                var option = document.createElement("option");
                if (key == 0) { option.selected = true; }
                option.value = list[key]["id"];
                option.innerText = list[key]["name"];
                if (list[key]["price"] != 0) option.innerText += " (+" + list[key]["price"] + "lv)";
                doughs.appendChild(option);
            }

        }
    };

    xhttp.open("GET", "index.php?target=pizza&action=getDoughs", true);
    xhttp.send();
}

function getSizes() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var sizes = document.getElementById("sizes");
            var list = JSON.parse(this.responseText);
            for (var key in list) {
                var option = document.createElement("option");
                option.value = list[key]["id"];
                option.innerText = list[key]["name"];
                if (option.innerText == "Large") option.selected = true;
                price += list[key]["price"];
                option.innerText += " (" + list[key]["slices"] + " slices)";
                sizes.appendChild(option);
            }

        }
    };

    xhttp.open("GET", "index.php?target=pizza&action=getSizes", true);
    xhttp.send();
}

function getPizza() {
    var xhttp = new XMLHttpRequest();
    var url = window.location.search.substr(1);
    url = url.split("&");
    url = url[url.length - 1];
    var id = url.split("=");
    id = id[id.length - 1];

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var pizza = JSON.parse(this.responseText);
            var img = document.getElementById("img");
            img.src = pizza["img_url"];

            var name = document.getElementById("name");
            name.innerText = pizza["name"];

            var id = document.getElementById("id");
            id.value = pizza["id"];

            var toppings = document.getElementById("toppings");
            var str = [];
            for (var ingr in pizza["ingredients"]) {
                str[ingr] = pizza["ingredients"][ingr]["name"];
            }
            toppings.innerText = str.join(", ");

            var price = document.getElementById("price-for-one");
            price.innerText = pizza["price"];
            document.getElementById("price").innerText =  pizza["price"];
        }
    };

    xhttp.open("GET", "index.php?target=pizza&action=getPizza&id=" + id, true);
    xhttp.send();
}

function getSauces() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var saucesEl = document.getElementById("sauces");
            var sauces = JSON.parse(this.responseText);
            for(var key in sauces) {
                var input = document.createElement("input");
                input.type = "radio";
                input.value = sauces[key]["id"];
                input.id = "sauce" + sauces[key]["id"];
                input.name = "sauces[]";

                toppings = document.getElementById("toppings");
                toppings = toppings.innerText;
                toppings = toppings.split(", ");
                if (toppings.includes(sauces[key]["name"])) {
                    input.checked = true;
                }

                var label = document.createElement("label");
                label.innerText = sauces[key]["name"];
                label.setAttribute("for", "sauce" + sauces[key]["id"]);

                saucesEl.appendChild(input);
                saucesEl.appendChild(label);

                var br = document.createElement("br");
                saucesEl.appendChild(br);
            }
        }
    };

    xhttp.open("GET", "index.php?target=pizza&action=getIngr&category=1", true);
    xhttp.send();
}

function getIngr($category) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var categoryName = "";
            switch ($category) {
                case 2 : categoryName = "herbs"; break;
                case 3 : categoryName = "cheeses"; break;
                case 4 : categoryName = "meats"; break;
                case 5 : categoryName = "vegetables"; break;
                case 6 : categoryName = "miscellaneous"; break;
            }
            var ingredientEl = document.getElementById(categoryName);
            var ingredients = JSON.parse(this.responseText);
            for(var key in ingredients) {
                var input = document.createElement("input");
                input.type = "checkbox";
                input.value = ingredients[key]["id"];
                input.id = $category + "_" + ingredients[key]["id"];
                input.name = categoryName + "[]";
                input.className = categoryName;


                //input.onselect = priceChangeForIngr(ingredients[key]["id"]);

                toppings = document.getElementById("toppings");
                toppings = toppings.innerText;
                toppings = toppings.split(", ");
                if (toppings.includes(ingredients[key]["name"])) {
                    input.checked = true;
                }

                input.addEventListener("click", function (event) {
                    var price = document.getElementById("price-for-one");
                    var targetElement = event.target;
                    if (this.checked == true) {
                        addIngrPrice(targetElement.value);
                    }else {
                        if(toppings.includes())
                        removeIngrPrice(targetElement.value);
                    }
                });

                var label = document.createElement("label");
                label.innerText = ingredients[key]["name"];
                label.setAttribute("for", $category + "_" + ingredients[key]["id"]);

                ingredientEl.appendChild(input);
                ingredientEl.appendChild(label);

                var br = document.createElement("br");
                ingredientEl.appendChild(br);
            }
        }
    };

    xhttp.open("GET", "index.php?target=pizza&action=getIngr&category=" + $category, true);
    xhttp.send();
}


function changePrice() {
    var price = document.getElementById("price-for-one");
    price.innerText = "0";
    var id;

    var doughs = document.getElementById("doughs");
    try {
        id = doughs.options[doughs.selectedIndex].value;
    } catch (e) {
        id = 1;
    }
    getPriceOfDough(id, price);

    var sizes = document.getElementById("sizes");
    try {
        id = sizes.options[sizes.selectedIndex].value;
    } catch (e) {
        id = 2;
    }
    getPriceOfSize(id, price);

    for (i = 2; i <= 6; i++) {
        addIngredients(i);
    }


}

function addIngredients(category) {
    var categoryName = "";
    switch (category) {
        case 2 : categoryName = "herbs"; break;
        case 3 : categoryName = "cheeses"; break;
        case 4 : categoryName = "meats"; break;
        case 5 : categoryName = "vegetables"; break;
        case 6 : categoryName = "miscellaneous"; break;
    }

    var elements = document.getElementsByClassName(categoryName);
    var i;
    for (i = 0; i < elements.length; i++) {
        if (elements[i].checked) {
            addIngrPrice(elements[i].value, price);
        }
    }

}

function addIngrPrice(ingr_id) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var price = document.getElementById("price-for-one");
            //alert(price.innerText);
            var priceVal = parseFloat(this.responseText);
            //alert(priceVal);
            priceVal += parseFloat(price.innerText);

            price.innerText = priceVal;
            document.getElementById("price").innerText = price.innerText;
        }
    };

    xhttp.open("GET", "index.php?target=pizza&action=getIngrPrice&id=" + ingr_id, true);
    xhttp.send();
}

function removeIngrPrice(ingr_id) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var price = document.getElementById("price-for-one");
            //alert(price.innerText);
            //alert(priceVal);
            var priceVal = parseFloat(price.innerText);
            priceVal -= parseFloat(this.responseText);

            price.innerText = priceVal;
            document.getElementById("price").innerText = price.innerText;
        }
    };

    xhttp.open("GET", "index.php?target=pizza&action=getIngrPrice&id=" + ingr_id, true);
    xhttp.send();
}

function getPriceOfDough(dough_id, price) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var priceVal = parseFloat(this.responseText);
            priceVal += parseFloat(price.innerText);

            price.innerText = priceVal;
            document.getElementById("price").innerText = price.innerText;
        }
    };

    xhttp.open("GET", "index.php?target=pizza&action=getDoughPrice&id=" + dough_id, true);
    xhttp.send();
}

function getPriceOfSize(size_id, price) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var priceVal = parseFloat(this.responseText);
            priceVal += parseFloat(price.innerText);

            price.innerText = priceVal;
            document.getElementById("price").innerText = price.innerText;
        }
    };

    xhttp.open("GET", "index.php?target=pizza&action=getSizePrice&id=" + size_id, true);
    xhttp.send();
}


function incrementVal() {
    var value = parseInt(document.getElementById('quantity').value, 10);
    value = isNaN(value) ? 1 : value;
    value++;

    var price_for_one = document.getElementById("price-for-one");
    var price = document.getElementById("price");
    price.innerText = parseFloat(price_for_one.innerText) * value;

    document.getElementById('quantity').value = value;
}

function decrementVal() {
    var value = parseInt(document.getElementById('quantity').value, 10);
    value = isNaN(value) ? 1 : value;
    if (value > 1) {
        value--;

        var price_for_one = document.getElementById("price-for-one");
        var price = document.getElementById("price");
        price.innerText = parseFloat(price_for_one.innerText) * value;

        document.getElementById('quantity').value = value;
    }
}

function hideOrShow() {
    var customize = document.getElementById("customize");

    if (customize.style.display == "none") {
        customize.style.display = "block";
    } else {
        customize.style.display = "none";
    }
}