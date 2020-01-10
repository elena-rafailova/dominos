<?php
use model\City;
include_once "header.php";

if(!isset($cities)) {
    header("Location : index.php?target=address&action=add");
}
?>

<h4>Add a new address</h4>
<div style="float: left">
    <form action="index.php?target=address&action=add" method="post">

        <label>ADDRESS NAME</label><br>
        <input type="text" name="name" placeholder="e.g: Home"  maxlength="40" /><br>
        <label>STREET NAME *</label><br>
        <input type="text" name="street_name" maxlength="40" required /><br>
        <label>STREET NUMBER *</label><br>
        <input type="number" min="0" max="999" name="street_number" required /><br>
        <label>CITY *</label><br>
        <select name="city" required>
           <option value='' selected disabled hidden>Choose here</option>
            <?php /** @var City $city */
            foreach($cities as $city) {
            echo "<option value='".$city->getId()."'>".$city->getName()."</option>";
            }?>
        </select><br>
        <label >PHONE NUMBER *</label><br>
        <input type="tel" name="phone_number"  minlength="9" maxlength="15" required   /><br>
        <label>FLOOR</label><br>
        <input type="number" min="0" max="999" name="floor"/><br>
        <label>BUILDING NUMBER</label><br>
        <input type="text" name="building_number" maxlength="6" /><br>
        <label>APARTMENT NUMBER</label><br>
        <input type="text" name="apartment_number" maxlength="6" /><br>
        <label>ENTRANCE</label><br>
        <input type="text" name="entrance" maxlength="6"   /><br>

        <input type="submit" name="add" value="Add"  /><br>
    </form>
