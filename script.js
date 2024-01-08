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
