<?php

include_once "header.php";

?>
<div class="container text-center center" >
    <h3 class="font-weight-bold text-center">MODIFY YOUR DETAILS, ADD OR DELETE AN ADDRESS</h3>
    <div id="addresses">

    </div>
    <div id="address_form_div"  >
        <form id="edit_address" method="post" action="">
            <div class="col-md-10 mx-auto " >
                <div class="input-group mb-1">
                    <div class="form-group mx-auto">
                        <label class="font-weight-bold">ADDRESS NAME</label>
                        <input  id="address_name" class="form-control " type="text" name="name" placeholder="e.g: Home" maxlength="40"
                            value=""/>
                    </div>
                    <div class="form-group mr-2 ml-2 ">
                        <label class="font-weight-bold">STREET NAME *</label>
                        <input id="street_name" class="form-control " type="text" name="street_name" maxlength="40"
                            value="" required/>
                    </div>
                    <div class="form-group  mr-2 ml-2 ">
                        <label class="font-weight-bold">STREET NUMBER *</label>
                        <input id="street_number" class="form-control  " type="number" name="street_number" min="0" max="999" value=""
                            required/>
                    </div>
                    <div class="form-group mx-auto">
                        <label class="font-weight-bold">CITY *</label>
                        <select name="city" class="form-control " readonly>
                            <option id="city_select" value=""></option>
                        </select>
                    </div>
                    <div class="form-group mr-2 ml-2 ">
                        <label class="font-weight-bold">PHONE NUMBER *</label>
                        <input id="phone_number" class="form-control " type="tel" name="phone_number" minlength="9" maxlength="15"
                               value="" required/>
                    </div>
                    <div class="form-group  mx-auto">
                        <label class="font-weight-bold">FLOOR</label>
                        <input id="floor" class="form-control " type="number" name="floor" min="0" max="999" value=""/>
                    </div>
                </div>
            </div>
            <div class="col-md-11 mx-auto " >
                <div class="input-group mb-1">

                    <div class="form-group mx-auto">
                        <label class="font-weight-bold">BUILDING NUMBER</label>
                        <input id="building_number" class="form-control " type="text" name="building_number" maxlength="6"
                               value=""/>
                    </div>
                    <div class="form-group ml-2 mr-2">
                        <label class="font-weight-bold">APARTMENT NUMBER</label>
                        <input id="apartment_number" class="form-control " type="text" name="apartment_number" maxlength="6" value=""/>
                    </div>
                    <div class="form-group mx-auto">
                        <label class="font-weight-bold">ENTRANCE</label>
                        <input id="entrance" class="form-control" type="text" name="entrance" maxlength="6" value=""/>
                    </div>
                        <input id="address_id" type="hidden" name="id" value=""/>
                </div>
            </div>
    </div>
        <div id="mod_buttons" class="text-center col-xs-12 col-md-7 ">
            <div id="change" class="col-md-12 "  >
                <input type="submit" class="btn btn-outline-success" onclick="submitForm('index.php?target=address&action=change')"
                       value="Change" name="change">
            </div>
            <div id="delete"class="col-md-12 " >
                <input type="submit" class="btn btn-outline-danger" onclick="submitForm('index.php?target=address&action=delete')"
                       value="Delete" name="delete">
            </div>
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



