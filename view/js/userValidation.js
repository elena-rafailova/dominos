
document.addEventListener("DOMContentLoaded", function() {

    // JavaScript form validation
    var first_name_input = document.getElementById("first_name");
    var last_name_input = document.getElementById("last_name");
    var password_input = document.getElementById("password");
    var email = document.getElementById("email");
    var verify_password_input = document.getElementById("verify_password");

    var myForm = document.getElementById("register_form");

    document.getElementById("password_match").style.display = "none";

    var password = document.getElementById("password");
    var verify_password = document.getElementById("verify_password");
    verify_password.addEventListener("keyup", function () {
        if(password.value === verify_password.value ) {
            document.getElementById("password_match").style.display = "none";
            password.setCustomValidity(password.validity.patternMismatch ? password.title : "");
        }
        else {
            document.getElementById("password_match").style.display = "block";
        }
    });


    
    if(!RegExp.escape) {
        RegExp.escape = function(s) {
            return String(s).replace(/[\\^$*+?.()|[\]{}]/g, '\\$&');
        };
    }

    var supports_input_validity = function()
    {
        var i = document.createElement("input");
        return "setCustomValidity" in i;
    };

    if(supports_input_validity()) {

        first_name_input.setCustomValidity(first_name_input.title);

        last_name_input.setCustomValidity(last_name_input.title);

        password_input.setCustomValidity(password_input.title);

        email.setCustomValidity(email.title);

        // input key handlers

        first_name_input.addEventListener("blur", function(e) {
            first_name_input.setCustomValidity(this.validity.patternMismatch ? first_name_input.title : "");
        }, false);

        last_name_input.addEventListener("blur", function(e) {
            last_name_input.setCustomValidity(this.validity.patternMismatch ? last_name_input.title : "");
        }, false);

        email.addEventListener("blur", function(e) {
            email.setCustomValidity(this.validity.patternMismatch ? email.title : "");
        }, false);


        password_input.addEventListener("blur", function(e) {
            this.setCustomValidity(this.validity.patternMismatch ? password_input.title : "");
            if(this.checkValidity()) {
                verify_password_input.pattern = RegExp.escape(this.value);
                verify_password_input.setCustomValidity(verify_password_input.title);
            } else {
                verify_password_input.pattern = this.pattern;
                verify_password_input.setCustomValidity("");
            }
        }, false);

        verify_password_input.addEventListener("blur", function(e) {
            this.setCustomValidity(this.validity.patternMismatch ? verify_password_input.title : "");
        }, false);

    }

}, false);


var email = document.getElementById("email");
email.addEventListener("blur", function (){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var email_exists = document.getElementById("email_exists");
            email_exists.innerHTML = "";
            var validation = this.responseText;
            validation = JSON.parse(validation);

            var register_button = document.getElementById("register_button");
            if(validation === "exists") {
                email_exists.style.display="block";
                email_exists.innerText = "User with that email already exists!";
                register_button.disabled = true;
            } else {
                email_exists.style.display="none";
                register_button.disabled = false;
            }
        }
    };
    var value = email.value;
    xhttp.open("GET", "index.php?target=user&action=userExists&email=" + value , true);
    xhttp.send();
});

var login_email = document.getElementById("login_email");
login_email.addEventListener("blur", function (){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var user_exists = document.getElementById("user_exists");
            user_exists.innerHTML = "";
            var validation = this.responseText;
            validation = JSON.parse(validation);

            var login_button = document.getElementById("login_button");
            if(validation === "doesn't") {
                user_exists.style.display="block";
                user_exists.innerText = "User with that email doesn't exist!";
                login_button.disabled = true;
            } else {
                user_exists.style.display="none";
                login_button.disabled = false;
            }
        }
    };
    var value = login_email.value;
    xhttp.open("GET", "index.php?target=user&action=userExists&email=" + value , true);
    xhttp.send();
});


function forgotPass() {
    var forgot_email = document.getElementById("forgot_email");
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert("An email has been sent to you with a link to reset your password.\n" +
                "Please check the email that you provided.");
        }
    };
    xhttp.open("POST", "index.php?target=user&action=forgotPassword", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    // xhttp.open("GET", "index.php?target=user&action=userExists&email=" + value , true);
    xhttp.send("forgot_email="+forgot_email.value);
    // xhttp.send();

}


