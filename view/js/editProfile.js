function checkPasswords(){
    document.getElementById("password_match").style.display = "none";
    document.getElementById("password_entered").style.display = "none";
    var edit_button= document.getElementById("edit_button");
    var password = document.getElementById("password");
    var new_password = document.getElementById("new_password");
    var verify_password = document.getElementById("verify_password");
    new_password.addEventListener("keyup", function () {
        if (password.value == "") {
            document.getElementById("password_entered").style.display = "block";
            edit_button.disabled= true;
        } else {
            document.getElementById("password_entered").style.display = "none";
            edit_button.disabled= false;
        }
    });
    verify_password.addEventListener("keyup", function () {
        if(new_password.value === verify_password.value ) {
            document.getElementById("password_match").style.display = "none";
            new_password.setCustomValidity(new_password.validity.patternMismatch ? new_password.title : "");
            edit_button.disabled= false;
        }
        else {
            document.getElementById("password_match").style.display = "block";
            edit_button.disabled= true;
        }
    });
}