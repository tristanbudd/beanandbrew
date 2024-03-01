window.onload = function() {
    const menu_button = document.querySelector('.burger');
    const mobile_menu = document.querySelector('.mobile-nav');
    const first_input = document.getElementById("username");

    menu_button.addEventListener('click', function() {
        menu_button.classList.toggle('is-active');
        mobile_menu.classList.toggle('is-active');
    });

    first_input.focus()
}

function toggle_view_password() {
    const password_input = document.getElementById("password");
    const password_view_text = document.getElementById("password_view_text");
    if (password_input.type === "password") {
        password_input.type = "text";
        password_view_text.textContent = "Hide Password";
    } else {
        password_input.type = "password";
        password_view_text.textContent = "Show Password";
    }
}

const password_input = document.getElementById("password");
const confirm_password_input = document.getElementById("confirm_password");
const email_input = document.getElementById("email");
const username_input = document.getElementById("username");
const valid_email = document.getElementById("valid_email");
const username3 = document.getElementById("username3");
const username32 = document.getElementById("username32");
const email3 = document.getElementById("email3");
const email128 = document.getElementById("email128");
const letter = document.getElementById("letter");
const capital = document.getElementById("capital");
const number = document.getElementById("number");
const symbol = document.getElementById("symbol");
const length = document.getElementById("length");
const matching = document.getElementById("matching");

username_input.onfocus = function() {
    document.getElementById("username_check").style.display = "block";
}

username_input.onblur = function() {
    document.getElementById("username_check").style.display = "none";
}

email_input.onfocus = function() {
    document.getElementById("email_check").style.display = "block";
}

email_input.onblur = function() {
    document.getElementById("email_check").style.display = "none";
}

password_input.onfocus = function() {
    document.getElementById("password_check").style.display = "block";
}

password_input.onblur = function() {
    document.getElementById("password_check").style.display = "none";
}

confirm_password_input.onfocus = function() {
    document.getElementById("password_confirm_check").style.display = "block";
}

confirm_password_input.onblur = function() {
    document.getElementById("password_confirm_check").style.display = "none";
}

username_input.onkeyup = function() {
    if(username_input.value.length >= 2) {
        username3.classList.remove("invalid");
        username3.classList.add("valid");
    } else {
        username3.classList.remove("valid");
        username3.classList.add("invalid");
    }

    if(username_input.value !== "" && username_input.value.length <= 32) {
        username32.classList.remove("invalid");
        username32.classList.add("valid");
    } else {
        username32.classList.remove("valid");
        username32.classList.add("invalid");
    }
}

email_input.onkeyup = function() {
    if(email_input.value.match(/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/g)) {
        valid_email.classList.remove("invalid");
        valid_email.classList.add("valid");
    } else {
        valid_email.classList.remove("valid");
        valid_email.classList.add("invalid");
    }

    if(email_input.value.length >= 3) {
        email3.classList.remove("invalid");
        email3.classList.add("valid");
    } else {
        email3.classList.remove("valid");
        email3.classList.add("invalid");
    }

    if(email_input.value !== "" && email_input.value.length <= 128) {
        email128.classList.remove("invalid");
        email128.classList.add("valid");
    } else {
        email128.classList.remove("valid");
        email128.classList.add("invalid");
    }
}

password_input.onkeyup = function() {
    if(password_input.value.match(/[a-z]/g)) {
        letter.classList.remove("invalid");
        letter.classList.add("valid");
    } else {
        letter.classList.remove("valid");
        letter.classList.add("invalid");
    }

    if(password_input.value.match(/[A-Z]/g)) {
        capital.classList.remove("invalid");
        capital.classList.add("valid");
    } else {
        capital.classList.remove("valid");
        capital.classList.add("invalid");
    }

    if(password_input.value.match(/[0-9]/g)) {
        number.classList.remove("invalid");
        number.classList.add("valid");
    } else {
        number.classList.remove("valid");
        number.classList.add("invalid");
    }

    if(password_input.value.match(/[#?!@$%^&*-]/g)) {
        symbol.classList.remove("invalid");
        symbol.classList.add("valid");
    } else {
        symbol.classList.remove("valid");
        symbol.classList.add("invalid");
    }

    if(password_input.value.length >= 8) {
        length.classList.remove("invalid");
        length.classList.add("valid");
    } else {
        length.classList.remove("valid");
        length.classList.add("invalid");
    }
}

confirm_password_input.onkeyup = function() {
    if(password_input.value !== "") {
        if (password_input.value == confirm_password_input.value) {
            matching.classList.remove("invalid");
            matching.classList.add("valid");
        } else {
            matching.classList.remove("valid");
            matching.classList.add("invalid");
        }
    }
}

function accept_cookies() {
    const cookie_notice_window = document.getElementById("cookie_notice_window");
    const date = new Date();
    date.setTime(date.getTime() + (30*24*60*60*1000));
    let expires = "expires="+ date.toUTCString();
    document.cookie = "cookie_notice" + "=" + "1" + ";" + expires + ";path=/";
    cookie_notice_window.remove()
}

function decline_cookies() {
    const cookie_notice_window = document.getElementById("cookie_notice_window");
    const date = new Date();
    date.setTime(date.getTime() + (30*24*60*60*1000));
    let expires = "expires="+ date.toUTCString();
    document.cookie = "cookie_notice" + "=" + "0" + ";" + expires + ";path=/";
    cookie_notice_window.remove()
}