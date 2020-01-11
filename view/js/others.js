function getOthers(category_id, filter) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var table = document.getElementById("others");
            table.innerHTML = "";
            var others = this.responseText;
            others = JSON.parse(others);

            var tr = document.createElement("div");
            tr.setAttribute("class", "row");
            for (var key in others) {
                var other_element = document.createElement("div");
                other_element.setAttribute("class", " col-lg-3 col-sm-5 card text-decoration-none mb-2")
                //var br = document.createElement("br");

                var img = document.createElement("img");
                img.setAttribute("class", "product_img card-img-top");
                img.src = others[key].img_url;
                other_element.appendChild(img);

                var card_body = document.createElement("a");
                card_body.onclick = function() {getOptions(category_id, this.id)};
                card_body.setAttribute("class", "card-body text-center font-weight-light ");

                var p1 = document.createElement("h4");
                p1.innerText = others[key].name;
                p1.setAttribute("class", "cart-title text-uppercase");
                card_body.appendChild(p1);
                //
                // var hr = document.createElement("hr");
                // card_body.appendChild(p1);

                var p2 = document.createElement("p");
                p2.setAttribute("class", "card-text");
                p2.innerText = others[key].description;
                card_body.appendChild(p2);

                other_element.appendChild(card_body);

                var button = document.createElement("input");
                button.type = "button";
                button.value = "Choose";
                button.setAttribute("class", "btn btn-primary ");
                button.id = others[key].id + 'choose';
                button.onclick= function() {getOptions(category_id, this.id)}
                other_element.appendChild(button);

                var order_form = document.createElement("form");
                order_form.id= others[key].id + "order";
                order_form.style.display = "none";
                order_form.action = "index.php?target=cart&action=addToCart";
                order_form.method = "post";

                var other_id =document.createElement("input");
                other_id.type ="hidden";
                other_id.id = others[key].id + "id";
                other_id.name= "other_id";
                other_id.value =others[key].id;
                order_form.appendChild(other_id);

                var other_category_id =document.createElement("input");
                other_category_id.type ="hidden";
                other_category_id.id = others[key].id + "category_id";
                other_category_id.name= "category_id";
                other_category_id.value =category_id;
                order_form.appendChild(other_category_id);

                var p = document.createElement("input");
                p.type="hidden";
                p.id = others[key].id + "price_for_one";
                p.style.display = "none";
                p.name="price_for_one";
                p.value = parseFloat(others[key].price).toFixed(2);
                order_form.appendChild(p);

                var price = document.createElement("div");
                price.innerHTML = "Price: ";
                var span_price = document.createElement("span");
                span_price.id = others[key].id + "price";
                span_price.innerText = p.value + ' BGN';
                price.appendChild(span_price);
                order_form.appendChild(price);

                var quantity = document.createElement("h6");
                quantity.innerHTML= "Quantity";
                order_form.appendChild(quantity);

                var minus = document.createElement("img");
                minus.src = "uploads/minus.png";
                minus.id = "m" + others[key].id;
                minus.onclick = function () { decrementVal(this.id); };
                minus.setAttribute("class", "icons float-left")
                order_form.appendChild(minus);

                // var minus_button = document.createElement("input");
                // minus_button.type = "button";
                // minus_button.id = "m" + others[key].id;
                // minus_button.value = "-";
                // minus_button.onclick = function () {decrementVal(this.id);};
                // order_form.appendChild(minus_button);

                var quantity_text = document.createElement("input");
                quantity_text.type = "text";
                quantity_text.min = "1";
                quantity_text.max = "100";
                quantity_text.name ="quantity";
                quantity_text.id = others[key].id + "quantity";
                quantity_text.value = "1";
                quantity_text.readOnly = true;
                quantity_text.required = true;
                quantity_text.setAttribute("class", "float-left form-control w-50")
                order_form.appendChild(quantity_text);

                var plus = document.createElement("img");
                plus.src = "uploads/plus.png";
                plus.id = "p" + others[key].id;
                plus.onclick = function () { incrementVal(this.id); };
                plus.setAttribute("class", "float-left ")
                order_form.appendChild(plus);

                // var plus_button = document.createElement("input");
                // plus_button.type = "button";
                // plus_button.id = "p" + others[key].id;
                // plus_button.value = "+";
                // plus_button.onclick =  function () {incrementVal(this.id);};
                // order_form.appendChild(plus_button);

                var submit = document.createElement("input");
                submit.type = "submit";
                submit.name = "add_to_cart";
                submit.setAttribute("class", "float-right m-2 btn btn-primary ");
                submit.value = "Add";
                order_form.appendChild(submit);

                other_element.appendChild(order_form);

                tr.appendChild(other_element);
            }
            table.appendChild(tr);
        }
    };
    if(filter!= null) {
        var url = "index.php?target=other&action=getOthersInfo&category_id=" + category_id + "&filter=" + filter;
    } else {
        var url = "index.php?target=other&action=getOthersInfo&category_id=" + category_id;
    }

    xhttp.open("GET", url , true);
    xhttp.send();
}

function getOptions(category_id, id) {
        var id1 =id;
        id1 = id1.replace('choose','');
        var form = document.getElementById(id1 + "order");

        var display_setting = form.style.display;

        if (display_setting === "none") {
            form.style.display = "block";
        } else {
            form.style.display = "none";
         }
}

function incrementVal(id) {
    var id1 =id;
    id1 = id1.replace('p','');
    var value = parseInt(document.getElementById(id1 + 'quantity').value, 10);

    value = isNaN(value) ? 1 : value;
    value++;


    var price = document.getElementById(id1 + "price");
    var price_for_one = document.getElementById(id1+ "price_for_one");
    price.innerText = (parseFloat(price_for_one.value) * value).toFixed(2) + ' BGN';

    document.getElementById(id1 + 'quantity').value = value;
}

function decrementVal(id) {
    var id1 =id;
    id1 = id1.replace('m','');
    var value = parseInt(document.getElementById(id1 + 'quantity').value, 10);
    value = isNaN(value) ? 1 : value;
    if (value > 1) {
        value--;


        var price = document.getElementById(id1 + "price");
        var price_for_one = document.getElementById(id1 + "price_for_one");
        price.innerHTML = (parseFloat(price_for_one.value) * value).toFixed(2) + ' BGN';

        document.getElementById(id1 + 'quantity').value = value;
    }
}