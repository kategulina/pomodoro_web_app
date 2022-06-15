const pass = document.getElementById("newPasswordInput");
var confirmed_pass = document.getElementById("passConformationInput");
var username = document.getElementById("newUserNameInput");

/* Control if name is longer than 3 symbols */
username.onkeyup = function controlName() {
    var usernameVal = username.value;
    if (usernameVal.length <= 3) {
        username.setCustomValidity("This name can't be real!");
    } else {
        username.setCustomValidity("");
    }
}

/* Control if password and confirmed passwords match */
confirmed_pass.onkeyup = function controlPass() {
    if (pass.value != confirmed_pass.value) {
        confirmed_pass.setCustomValidity("Passwords are different!");
    } else {
        confirmed_pass.setCustomValidity("");
    }
}

regForm = document.getElementById("registrationForm");

/* Form check on submit */
regForm.addEventListener("submit", function (event) {

    /* Check username input – it must be longer than 3 symbols */
    var usernameVal = username.value;
    /* HACK username can't be "users" */
    if (usernameVal.length < 3 || usernameVal == "users") {
        event.preventDefault();
        username.setCustomValidity("This name can't be real!");
    } else {
        username.setCustomValidity("");
    }
    if (username)

    /* Control if passwords match */
    if (pass.value != confirmed_pass.value) {
        event.preventDefault();
        confirmed_pass.setCustomValidity("Passwords are different!");
    } else {
        confirmed_pass.setCustomValidity("");
    }
})
