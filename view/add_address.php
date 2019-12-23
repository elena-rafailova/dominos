<?php
include_once "main.php";
//todo add google maps!
?>

<h4>Add a new address</h4>
<div style="float: left">
    <form action="index.php?target=address&action=add" method="post">

        <label>ADDRESS NAME</label><br>
        <input type="text" name="name" placeholder="e.g: Home"  /><br>
        <label>STREET NAME *</label><br>
        <input type="text" name="street_name"  required /><br>
        <label>STREET NUMBER *</label><br>
        <input type="number" name="street_number"  required /><br>
        <label>CITY *</label><br>
        <select name="city" required>
            <option value="1">Sofia</option>
            <option value="2">Plovdiv</option>
            <option value="3">Varna</option>
        </select><br>
        <label >PHONE NUMBER *</label><br>
        <input type="tel" name="phone_number" required   /><br>
        <label>FLOOR</label><br>
        <input type="number" name="floor"/><br>
        <label>BUILDING NUMBER</label><br>
        <input type="text" name="building_number"  /><br>
        <label>APARTMENT NUMBER</label><br>
        <input type="text" name="apartment_number"  /><br>
        <label>ENTRANCE</label><br>
        <input type="text" name="entrance"   /><br>

        <input type="submit" name="add" value="Add"  /><br>
    </form>
