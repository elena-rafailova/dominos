
function loadOrders(page) {
    if (page == null) {
        page = 1;
    }
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var response = this.responseText;
            response = JSON.parse(response);

            var container = document.getElementById("orders-container");
            container.innerHTML = "";

            if (response.error == "false") {
                if (response.orders == "empty") {
                    var empty_msg = document.createElement("h6");
                    empty_msg.setAttribute("class", "font-weight-bold");
                    empty_msg.innerText = "Your order history is empty!";
                    container.appendChild(empty_msg);
                    document.getElementById("prev").disabled = true;
                    document.getElementById("next").disabled = true;
                } else {
                    var orders = response.result;

                    var max_page = orders.max_pages;
                    orders = orders.orders;

                    for (var key in orders) {
                        var orderRecord = document.createElement("tr");
                        orderRecord.setAttribute("class", "row");

                        var date_created = document.createElement("td");
                        date_created.setAttribute("class", "col-sm-3");
                        date_created.innerText = orders[key].date_created;
                        orderRecord.appendChild(date_created);

                        var items = document.createElement("td");
                        items.setAttribute("class", "col-sm-5");
                        items.innerHTML = orders[key].items;
                        orderRecord.appendChild(items);

                        var price = document.createElement("td");
                        price.setAttribute("class", "col-sm-2");
                        price.innerText = parseFloat(orders[key].total_price).toFixed(2) + " BGN";
                        orderRecord.appendChild(price);


                        var status = document.createElement("td");
                        status.setAttribute("class", "col-sm-2");
                        status.innerText = orders[key].status;
                        orderRecord.appendChild(status);

                        container.appendChild(document.createElement("hr"));
                        container.appendChild(orderRecord);

                        if (page <= 1) {
                            document.getElementById("prev").disabled = true;
                        }
                        if (page >= max_page) {
                            document.getElementById("next").disabled = true;
                        }
                    }
                }

             } else {
                document.getElementById("next").disabled = true;
                document.getElementById("prev").disabled = true;
                var invalid_page = document.createElement("h3");
                invalid_page.setAttribute("class", "font-weight-bold");
                invalid_page.innerText = "Invalid Page!";
                container.appendChild(invalid_page);
            }
        }
    };
    xhttp.open("GET", "index.php?target=order&action=getOrders&page=" + page, true);
    xhttp.send();
}

function replaceUrlParam(url, paramName, paramValue)
{
    if (paramValue == null) {
        paramValue = '';
    }
    var pattern = new RegExp('\\b('+paramName+'=).*?(&|#|$)');
    if (url.search(pattern)>=0) {
        return url.replace(pattern,'$1' + paramValue + '$2');
    }
    url = url.replace(/[?#]$/,'');
    return url + (url.indexOf('?')>0 ? '&' : '?') + paramName + '=' + paramValue;
}

function nextPage(page) {
    var nextPage = parseInt(page)+1;
    var url = window.location.search;

    url = replaceUrlParam(url, "page", nextPage);
    window.location = window.location.pathname + url;
    //loadOrders(nextPage);

}

function previousPage(page) {
    var prevPage = parseInt(page)-1;
    var url = window.location.search;

    url = replaceUrlParam(url, "page", prevPage);
    window.location = window.location.pathname + url;
}