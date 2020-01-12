
document.addEventListener("DOMContentLoaded", function() {

    // JavaScript form validation
    var first_name_input = document.getElementById("first_name");
    var last_name_input = document.getElementById("last_name");
    var password_input = document.getElementById("password");
    var email = document.getElementById("email");
    var verify_password_input = document.getElementById("verify_password");

    var checkPassword = function(str)
    {

        var re = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/;
        return re.test(str);
    };

    var myForm = document.getElementById("register_form");
    
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

        first_name_input.addEventListener("keyup", function(e) {
            first_name_input.setCustomValidity(this.validity.patternMismatch ? first_name_input.title : "");
        }, false);

        last_name_input.addEventListener("keyup", function(e) {
            last_name_input.setCustomValidity(this.validity.patternMismatch ? last_name_input.title : "");
        }, false);

        email.addEventListener("keyup", function(e) {
            email.setCustomValidity(this.validity.patternMismatch ? email.title : "");
        }, false);

        password_input.addEventListener("keyup", function(e) {
            this.setCustomValidity(this.validity.patternMismatch ? password_input.title : "");
            if(this.checkValidity()) {
                verify_password_input.pattern = RegExp.escape(this.value);
                verify_password_input.setCustomValidity(verify_password_input.title);
            } else {
                verify_password_input.pattern = this.pattern;
                verify_password_input.setCustomValidity("");
            }
        }, false);

        verify_password_input.addEventListener("keyup", function(e) {
            this.setCustomValidity(this.validity.patternMismatch ? verify_password_input.title : "");
        }, false);

    }

}, false);

