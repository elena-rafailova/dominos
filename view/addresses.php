<?php
include_once "main.php";
//todo add google maps
?>
    <h4>MODIFY YOUR DETAILS, ADD OR DELETE AN ADDRESS</h4>
<div style="float: left">
    <p>
        <span>My addresses</span>
    </p>
    <ul>
        <li>home</li>
    </ul>
    <a href="index.php?view=add_address"><button>ADD A NEW ADDRESS</button></a>
</div>
<div style="float: left" >
        <form id="edit_address" method="post" action="">
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
        <input type="text" name="entrance"   /><br><br>

        <div style="float: left ;width: 30%; margin-right: 8px;">
                <img  src="uploads/green_check.svg" width="30px" height="30px" alt="Change" /><br>
                <input type="button" onclick="submitForm('index.php?target=address&action=change')" value="Change" name="change">
        </div>
        <div style="float: left; width: 30%;">
            <img src="uploads/delete_cross.svg" width="30px" height="30px" alt="Delete" /><br>
            <input type="button" onclick="submitForm('index.php?target=address&action=delete')" value="Delete" name="delete">
        </div>
</form>
</div>

<script type="text/javascript">
    function submitForm(action) {
        var form = document.getElementById('edit_address');
        form.action = action;
        form.submit();
    }
</script>



