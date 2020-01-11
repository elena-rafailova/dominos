<?php
use model\City;
include_once "header.php";

if(!isset($cities)) {
    header("Location : index.php?target=address&action=add");
}

$user = json_decode($_SESSION['logged_user']);
?>
<div class="container text-center">
    <h3 class="font-weight-bold text-center">Add new address</h3>
    <form action="index.php?target=address&action=add" method="post">
            <div class="col-md-8 mx-auto " >
                <div class="input-group mb-3">
                    <div class="form-group mx-auto">
                        <label class="font-weight-bold">ADDRESS NAME</label><br>
                        <input type="text" class="form-control " name="name" placeholder="e.g: Home"  maxlength="40" /><br>
                    </div>
                    <div class="form-group mr-2 ml-2 ">
                        <label class="font-weight-bold">STREET NAME *</label><br>
                        <input type="text" class="form-control " name="street_name" maxlength="40" required /><br>
                    </div>
                    <div class="form-group  mx-auto ">
                        <label class="font-weight-bold">STREET NUMBER *</label><br>
                        <input type="number" class="form-control" min="0" max="999" name="street_number" required /><br>
                    </div>
                    <div class="form-group  mx-auto">
                        <label class="font-weight-bold">CITY *</label><br>
                        <select name="city" class="form-control" required>
                           <option value='' selected disabled hidden>Choose here</option>
                            <?php /** @var City $city */
                            foreach($cities as $city) {
                            echo "<option value='".$city->getId()."'>".$city->getName()."</option>";
                            }?>
                        </select><br>
                    </div>
                    <div class="form-group mr-2 ml-2 ">
                        <label class="font-weight-bold">PHONE NUMBER *</label><br>
                        <input type="tel" class="form-control" name="phone_number"  minlength="9" maxlength="15" required   /><br>
                    </div>
                    <div class="form-group  mx-auto">
                        <label class="font-weight-bold">FLOOR</label><br>
                        <input type="number" class="form-control" min="0" max="999" name="floor"/><br>
                    </div>
                </div>
            </div>
                <div class="col-md-8 mx-auto " >
                    <div class="input-group mb-3">
                    <div class="form-group mx-auto">
                        <label class="font-weight-bold">BUILDING NUMBER</label><br>
                        <input type="text" class="form-control" name="building_number" maxlength="6" /><br>
                    </div>
                    <div class="form-group mr-2 ml-2">
                        <label class="font-weight-bold">APARTMENT NUMBER</label><br>
                        <input type="text" class="form-control" name="apartment_number" maxlength="6" /><br>
                    </div>
                    <div class="form-group mx-auto">
                        <label class="font-weight-bold">ENTRANCE</label><br>
                        <input type="text" class="form-control" name="entrance" maxlength="6"   /><br>
                    </div>
                    </div>
                </div>
                    <div class="col-md-7 mx-auto">
                        <input type="submit" class="btn btn-primary " name="add" value="Add"  /><br>
                    </div>
    </form>
</div>
