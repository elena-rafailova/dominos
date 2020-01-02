<?php

include_once "main.php";

if (!isset($addresses)) {
    header("index.php?target=address&action=show");
}
//todo add google maps
?>
    <h4>MODIFY YOUR DETAILS, ADD OR DELETE AN ADDRESS</h4>
<div style="float: left; margin-right: 30px">
    <p>
        <span>My addresses</span>
    </p>
    <ul>
    <?php
    if(!$addresses) {
        echo "You've no addresses yet. Please add new address";
    }
    else {
        foreach ($addresses as $address) {
            echo " <li><a href='index.php?target=address&action=show&id=$address->id'> ". $address->name." </li></a>";
        }
    }
    ?>
    </ul>
    <a href="index.php?view=add_address"><button>ADD A NEW ADDRESS</button></a>
</div>
<div style="float: left" >
    <?php
    if($addresses) {
        foreach ($addresses as $address) {
            if (isset($_GET['id']) && $_GET['id'] == $address->id) {
                ?>
                <form id="edit_address" method="post" action="">
                    <label>ADDRESS NAME</label><br>
                    <input type="text" name="name" placeholder="e.g: Home" maxlength="40"
                           value="<?= $address->name ?>"/><br>
                    <label>STREET NAME *</label><br>
                    <input type="text" name="street_name" maxlength="40"
                           value="<?= htmlspecialchars($address->street_name) ?>" required/><br>
                    <label>STREET NUMBER *</label><br>
                    <input type="number" name="street_number" min="0" max="999" value="<?= $address->street_number ?>"
                           required/><br>
                    <label>CITY *</label><br>
                    <select name="city" readonly>
                        <option value="<?= $address->city_id ?>">
                            <?php if ($address->city_id == 1) {
                                echo "Sofia";
                            } elseif ($address->city_id == 2) {
                                echo "Plovdiv";
                            } else {
                                echo "Varna";
                            } ?></option>
                    </select><br>
                    <label>PHONE NUMBER *</label><br>
                    <input type="tel" name="phone_number" minlength="9" maxlength="15"
                           value="<?= $address->phone_number ?>" required/><br>
                    <label>FLOOR</label><br>
                    <input type="number" name="floor" min="0" max="999" value="<?= $address->floor ?>"/><br>
                    <label>BUILDING NUMBER</label><br>
                    <input type="text" name="building_number" maxlength="6"
                           value="<?= $address->building_number ?>"/><br>
                    <label>APARTMENT NUMBER</label><br>
                    <input type="text" name="apartment_number" maxlength="6" value="<?= $address->apartment_number ?>"/><br>
                    <label>ENTRANCE</label><br>
                    <input type="text" name="entrance" maxlength="6" value="<?= $address->entrance ?>"/><br><br>
                    <input type="hidden" name="id" value="<?= $address->id ?>"/>
                    <div style="float: left ;width: 30%; margin-right: 8px;">
                        <img src="uploads/green_check.svg" width="30px" height="30px" alt="Change"/><br>
                        <input type="submit" onclick="submitForm('index.php?target=address&action=change')"
                               value="Change"
                               name="change">
                    </div>
                    <div style="float: left; width: 30%;">
                        <img src="uploads/delete_cross.svg" width="30px" height="30px" alt="Delete"/><br>
                        <input type="submit" onclick="submitForm('index.php?target=address&action=delete')"
                               value="Delete"
                               name="delete">
                    </div>
                </form>
                <?php
            }
        }
    }
        if(!isset($_GET['id'])) {
            ?>
            <form id="edit_address" method="post" action="">
                <label>ADDRESS NAME</label><br>
                <input type="text" name="name" placeholder="e.g: Home"  maxlength="40" /><br>
                <label>STREET NAME *</label><br>
                <input type="text" name="street_name"  maxlength="40" required /><br>
                <label>STREET NUMBER *</label><br>
                <input type="number" name="street_number" min="0" max="999"  required /><br>
                <label>CITY *</label><br>
                <select name="city"  required>
                    <option value="" selected disabled hidden>Choose here</option>
                    <option value="1">Sofia</option>
                    <option value="2">Plovdiv</option>
                    <option value="3">Varna</option>
                </select><br>
                <label >PHONE NUMBER *</label><br>
                <input type="tel" name="phone_number"  minlength="9" maxlength="15" required   /><br>
                <label>FLOOR</label><br>
                <input type="number" name="floor" min="0" max="999" /><br>
                <label>BUILDING NUMBER</label><br>
                <input type="text" name="building_number"  maxlength="6" /><br>
                <label>APARTMENT NUMBER</label><br>
                <input type="text" name="apartment_number"  maxlength="6" /><br>
                <label>ENTRANCE</label><br>
                <input type="text" name="entrance"  maxlength="6"  /><br><br>

            </form>
    <?php
    }
    ?>
</div>


<script type="text/javascript">
    function submitForm(action) {
        var form = document.getElementById('edit_address');
        form.action = action;
        form.submit();
    }
</script>



