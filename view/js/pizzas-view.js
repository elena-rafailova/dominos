function getPizzas(filter) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var container = document.getElementById("pizzas");
            container.innerHTML = "";
            var pizzas = this.responseText;
            pizzas = JSON.parse(pizzas);

            var row = document.createElement("div");
            row.setAttribute("class", "row ");
            for (var key in pizzas) {
                var pizza_element = document.createElement("a");
                pizza_element.href = "index.php?target=pizza&action=show&id=" + pizzas[key]["id"];
                pizza_element.setAttribute("class", "col-lg-3 col-sm-5 col-xs-6 card text-decoration-none");
                var br = document.createElement("br");

                var img = document.createElement("img");
                img.setAttribute("class", "product_img card-img-top");
                img.src = pizzas[key]["img_url"];
                pizza_element.appendChild(img);

                var str = [];
                for (var ingr in pizzas[key]["ingredients"]) {
                    str[ingr] = pizzas[key]["ingredients"][ingr]["name"];
                }

                var card_body = document.createElement("div");
                card_body.setAttribute("class", "card-body text-center font-weight-light ");

                var p1 = document.createElement("h4");
                p1.innerText = pizzas[key]["name"];
                p1.setAttribute("class", "cart-title text-uppercase");
                card_body.appendChild(p1);

                var p2 = document.createElement("p");
                p2.innerText = str.join(", ");
                p2.setAttribute("class", "card-text");
                card_body.appendChild(p2);


                pizza_element.appendChild(card_body);

                var button = document.createElement("a");
                button.type = "button";
                button.setAttribute("class", "btn btn-primary ");
                button.href = "index.php?target=pizza&action=show&id=" + pizzas[key]["id"];
                button.innerText = "Choose";

                pizza_element.appendChild(button);
                row.appendChild(pizza_element);
            }
            container.appendChild(row);
        }
    };

    xhttp.open("GET", "index.php?target=pizza&action=getPizzasInfo&filter=" + filter, true);
    xhttp.send();
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

function initializePizza() {
    var url = window.location.search.substr(1);
    url = url.split("&");
    url = url[url.length - 1];
    var id = url.split("=");
    pizzaId = id[id.length - 1];


    getPizza(pizzaId);
    getDoughs();
    getSizes();
    getSauces(pizzaId);

    var i;
    for (i = 2; i <= 6; i++) {
        getIngr(i, pizzaId);
    }

    var price_for_one = document.getElementById("price_for_one");

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
                option.setAttribute("class", "dropdown-item");
                if (key == 0) { option.selected = true; }
                option.value = list[key]["id"];
                option.innerText = list[key]["name"];
                if (list[key]["price"] != 0) option.innerText += " (+" + list[key]["price"] + " BGN)";
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
                option.innerText += " (" + list[key]["slices"] + " slices)";
                sizes.appendChild(option);
            }

        }
    };

    xhttp.open("GET", "index.php?target=pizza&action=getSizes", true);
    xhttp.send();
}

function getPizza(id) {
    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var pizza = JSON.parse(this.responseText);
            var img = document.getElementById("img");
            img.src = pizza["img_url"];

            var name = document.getElementById("name");
            name.innerText = pizza["name"];

            var pid = document.getElementById("id");
            pid.value = id;

            var toppings = document.getElementById("toppings");
            var str = [];
            for (var ingr in pizza["ingredients"]) {
                str[ingr] = pizza["ingredients"][ingr]["name"];
            }
            toppings.innerText = str.join(", ");

            var price_for_one = document.getElementById("price_for_one");
            price_for_one.value = pizza["price"].toFixed(2);
            document.getElementById("price").innerText =  pizza["price"].toFixed(2);
        }
    };

    xhttp.open("GET", "index.php?target=pizza&action=getPizza&id=" + id, true);
    xhttp.send();
}

function getSauces(pizzaId) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var saucesEl = document.getElementById("sauces");
            var all = JSON.parse(this.responseText);
            var sauces = all["ingredients"];
            var pizzaIngr = all["pizzaIngredients"];
            for(var key in sauces) {
                var input = document.createElement("input");
                input.type = "radio";
                input.value = sauces[key]["id"];
                input.id = "sauce" + sauces[key]["id"];
                input.name = "sauces[]";

                if (pizzaIngr.includes(sauces[key]["name"])) {
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

    xhttp.open("GET", "index.php?target=pizza&action=getIngr&category=1&pizza=" + pizzaId, true);
    xhttp.send();
}

function getIngr($category, pizzaId) {
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
            var all = JSON.parse(this.responseText);
            var ingredients = all["ingredients"];
            var pizzaIngr = all["pizzaIngredients"];
            for(var key in ingredients) {
                var input = document.createElement("input");
                input.type = "checkbox";
                input.value = ingredients[key]["id"];
                input.id = $category + "_" + ingredients[key]["id"];
                input.name = categoryName + "[]";
                input.className = categoryName;

                if (pizzaIngr.includes(ingredients[key]["name"])) {
                    input.checked = true;
                }

                input.addEventListener("click", function (event) {
                    var price_for_one = document.getElementById("price_for_one");
                    var targetElement = event.target;
                    if (this.checked == true) {
                        addIngrPrice(targetElement.value);
                    }else {
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

    xhttp.open("GET", "index.php?target=pizza&action=getIngr&category=" + $category + "&pizza=" + pizzaId, true);
    xhttp.send();
}

function changePrice() {
    var price_for_one = document.getElementById("price_for_one");
    price_for_one.value = 0;
    var id;

    var doughs = document.getElementById("doughs");
    id = doughs.options[doughs.selectedIndex].value;
    getPriceOfDough(id, price_for_one);

    var sizes = document.getElementById("sizes");
    id = sizes.options[sizes.selectedIndex].value;
    getPriceOfSize(id, price_for_one);

    var i;
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
            addIngrPrice(elements[i].value);
        }
    }

}

function addIngrPrice(ingr_id) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var price_for_one = document.getElementById("price_for_one");
            var priceVal = parseFloat(this.responseText);
            priceVal += parseFloat(price_for_one.value);

            price_for_one.value = priceVal.toFixed(2);

            var quantity = document.getElementById("quantity");
            if (quantity.value != quantity.defaultValue) {
                priceVal *= quantity.value;
            }
            document.getElementById("price").innerText = priceVal.toFixed(2);
        }
    };

    xhttp.open("GET", "index.php?target=pizza&action=getIngrPrice&id=" + ingr_id, true);
    xhttp.send();
}

function removeIngrPrice(ingr_id) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var price_for_one = document.getElementById("price_for_one");
            //alert(price.innerText);
            var priceVal = parseFloat(price_for_one.value);
            priceVal -= parseFloat(this.responseText);

            price_for_one.value = priceVal.toFixed(2);
            var quantity = document.getElementById("quantity");
            if (quantity.value != quantity.defaultValue) {
                priceVal *= quantity.value;
            }
            document.getElementById("price").innerText = priceVal.toFixed(2);
        }
    };

    xhttp.open("GET", "index.php?target=pizza&action=getIngrPrice&id=" + ingr_id, true);
    xhttp.send();
}

function getPriceOfDough(dough_id, price_for_one) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var priceVal = parseFloat(this.responseText);
            priceVal += parseFloat(price_for_one.value);

            price_for_one.value = priceVal;
            var quantity = document.getElementById("quantity");

            if (quantity.value != quantity.defaultValue) {
                priceVal *= parseFloat(quantity.value);
            }

            document.getElementById("price").innerText = priceVal.toFixed(2);
        }
    };

    xhttp.open("GET", "index.php?target=pizza&action=getDoughPrice&id=" + dough_id, true);
    xhttp.send();
}

function getPriceOfSize(size_id, price_for_one) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var priceVal = parseFloat(this.responseText);
            priceVal += parseFloat(price_for_one.value);

            price_for_one.value = priceVal.toFixed(2);
            var quantity = document.getElementById("quantity");
            if (quantity.value != quantity.defaultValue) {
                priceVal *= quantity.value;
            }

            document.getElementById("price").innerText = priceVal.toFixed(2);
        }
    };

    xhttp.open("GET", "index.php?target=pizza&action=getSizePrice&id=" + size_id, true);
    xhttp.send();
}


function incrementVal() {
    var value = parseInt(document.getElementById('quantity').value, 10);
    value = isNaN(value) ? 1 : value;
    value++;

    var price_for_one = document.getElementById("price_for_one");
    var price = document.getElementById("price");
    price.innerText = (parseFloat(price_for_one.value) * value).toFixed(2);

    document.getElementById('quantity').value = value;
}

function decrementVal() {
    var value = parseInt(document.getElementById('quantity').value, 10);
    value = isNaN(value) ? 1 : value;
    if (value > 1) {
        value--;

        var price_for_one = document.getElementById("price_for_one");
        var price = document.getElementById("price");
        price.innerText = (parseFloat(price_for_one.value) * value).toFixed(2);

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