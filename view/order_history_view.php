<?php

include_once "header.php";

?>
<script>
        var url = window.location.search.substr(1);
        url = url.split("&");
        url = url[url.length - 1];
        var page = url.split("=");
        page = page[page.length - 1];
</script>

<h3 class="font-weight-bold text-center">My orders</h3>
<div class="container  mb-3" id="orders-container">

</div>
<div id="pages" class="m-5">
    <button onclick="previousPage(page)" id="prev" class="btn btn-primary mt-3">Previous</button>
    <button onclick="nextPage(page)" id="next" class="btn btn-primary mt-3">Next</button>
</div>

<script>loadOrders(page);</script>






