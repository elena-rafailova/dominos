<?php

include_once "header.php";

?>

<div id="addresses" >

</div>
<div id="address_form_div" >
    <form id="edit_address" method="post" action="">
        <label>ADDRESS NAME</label><br>
        <input  id="address_name" type="text" name="name" placeholder="e.g: Home" maxlength="40"
               value=""/><br>
        <label>STREET NAME *</label><br>
        <input id="street_name" type="text" name="street_name" maxlength="40"
               value="" required/><br>
        <label>STREET NUMBER *</label><br>
        <input id="street_number" type="number" name="street_number" min="0" max="999" value=""
               required/><br>
        <label>CITY *</label><br>
        <select name="city" readonly>
            <option id="city_select" value=""></option>
        </select><br>
        <label>PHONE NUMBER *</label><br>
        <input id="phone_number" type="tel" name="phone_number" minlength="9" maxlength="15"
               value="" required/><br>
        <label>FLOOR</label><br>
        <input id="floor" type="number" name="floor" min="0" max="999" value=""/><br>
        <label>BUILDING NUMBER</label><br>
        <input id="building_number" type="text" name="building_number" maxlength="6"
               value=""/><br>
        <label>APARTMENT NUMBER</label><br>
        <input id="apartment_number" type="text" name="apartment_number" maxlength="6" value=""/><br>
        <label>ENTRANCE</label><br>
        <input id="entrance" type="text" name="entrance" maxlength="6" value=""/><br><br>
        <input id="address_id" type="hidden" name="id" value=""/>
        <div id="change" style="float: left ;width: 30%; margin-right: 8px;">
            <img src="uploads/green_check.svg" width="30px" height="30px" alt="Change"/><br>
            <input type="submit" onclick="submitForm('index.php?target=address&action=change')"
                   value="Change"
                   name="change">
        </div>
        <div id="delete" style="float: left; width: 30%;">
            <img src="uploads/delete_cross.svg" width="30px" height="30px" alt="Delete"/><br>
            <input type="submit" onclick="submitForm('index.php?target=address&action=delete')"
                   value="Delete"
                   name="delete">
        </div>
    </form>
</div>
    <script>viewAddresses();</script>
<script type="text/javascript">
    function submitForm(action) {
        var form = document.getElementById('edit_address');
        form.action = action;
        form.submit();
    }
</script>



