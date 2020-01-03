function getOthers(category_id, filter) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var table = document.getElementById("others");
            table.innerHTML = "";
            var others = this.responseText;
            others = JSON.parse(others);

            for (var key in others) {
                var tr = document.createElement("tr");
                var td = document.createElement("td");
                var br = document.createElement("br");

                var img = document.createElement("img");
                img.src = others[key]["img_url"];
                td.appendChild(img);

                var p1 = document.createElement("p");
                p1.innerText = others[key]["name"];

                var hr = document.createElement("hr");


                var p2 = document.createElement("p");
                p2.innerText = others[key]["description"];

                td.appendChild(p1);
                td.appendChild(hr);
                td.appendChild(p2);

                var button = document.createElement("input");
                button.type = "button";
                button.id = others[key]['id'];
                button.onclick = function (){getOptions(category_id, button.id)};
                button.value = "Choose";
                button.name = "choose";
                td.appendChild(button);

                var form = document.createElement("form");
                form.id = button.id + 'form';
                form.style.display='none';
                td.appendChild(form);

                tr.appendChild(td);
                table.appendChild(tr);
            }
        }
    };
    if(filter!= null) {
        var url = "index.php?target=others&action=getOthersInfo&category_id=" + category_id + "&filter=" + filter;
    } else {
        var url = "index.php?target=others&action=getOthersInfo&category_id=" + category_id;
    }

    xhttp.open("GET", url , true);
    xhttp.send();
}

function getOptions(category_id, clicked_id,) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var others = this.responseText;
            others = JSON.parse(others);

            var form = document.getElementById(clicked_id + 'form');
            var display_setting = form.style.display;
            console.log(form);
            if (display_setting === "none") {
                form.style.display = "block";
            } else {
                form.style.display = "none";
            }

            //form.action = "index.php..
            form.method = "post";

            var input1 = document.createElement("input");
            input1.type = "hidden";
            //input1.value = others[key]["id"];
            input1.name = "id";
            form.appendChild(input1);

            var price = document.createElement("input");
            price.type = "text";
            price.readOnly = true;
            //price.value = others[key]["price"] + ' BGN';
            form.appendChild(price);

            var quantity = document.createElement("input");
            quantity.type = "number";
            quantity.placeholder = "Choose quantity: ";
            // quantity.min =1;
            form.appendChild(quantity);


            var input2 = document.createElement("input");
            input2.type = "submit";
            input2.value = "Add to cart";
            // input2.name = "choose";

            form.appendChild(input2);

        }
     };
    xhttp.open("GET", "index.php?target=others&action=getOthersInfo&category_id=" + category_id, true);
    xhttp.send();
}