<?php
include_once "main.php";
?>
    <h4>MODIFY YOUR DETAILS, ADD OR DELETE AN ADDRESS</h4>
<div style="float: left">
    <p>
        <span>My addresses</span>
    </p>
    <ul>
        <li>home</li>
    </ul>
    <a href="index.php?target=address&action=add"><button>ADD A NEW ADDRESS</button></a>
</div>
<div style="float: left">
        <form name="edit_address" method="post">
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
        </form>
</div>
        <div style="float: left">
                <a href="index.php?target=address&action=change"><img src="uploads/green_check.svg" width="30px" height="30px" alt="Save" />Save</a>
        </div> <br><br><br><br><br>
        <div style="float: left ">
            <a href="index.php?target=address&action=delete"> <img src="uploads/delete_cross.svg" width="30px" height="30px" alt="Delete" />Delete</a>
        </div>



