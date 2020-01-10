
function loadOrders() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var orders = this.responseText;
            orders = JSON.parse(orders);

            var container = document.getElementById("orders-container");
            //var row = document.createElement("div");
            //row.setAttribute("class", "row");
            for (var key in orders){
                var orderRecord = document.createElement("div");
                orderRecord.setAttribute("class", "row");

                var date_created = document.createElement("div");
                date_created.setAttribute("class", "col-sm-3");
                date_created.innerText = orders[key].date_created;
                orderRecord.appendChild(date_created);

                var items = document.createElement("div");
                items.setAttribute("class", "col-sm-5");
                items.innerHTML = orders[key].items;
                orderRecord.appendChild(items);

                var price = document.createElement("div");
                price.setAttribute("class", "col-sm-2");
                price.innerText = parseFloat(orders[key].total_price).toFixed(2) + " BGN";
                orderRecord.appendChild(price);


                var status = document.createElement("div");
                status.setAttribute("class", "col-sm-2");
                status.innerText = orders[key].status;
                orderRecord.appendChild(status);

                container.appendChild(document.createElement("hr"));
                container.appendChild(orderRecord);
            }
            //container.appendChild(row);


        }
    };
    xhttp.open("GET", "index.php?target=order&action=getOrders", true);
    xhttp.send();
}