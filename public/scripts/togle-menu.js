const menu_elem = document.getElementById("side_menu");
const show_btn = document.getElementById("show_menu_btn");
const close_btn = document.getElementById("close_menu_btn");

show_btn.addEventListener("click", function (event) {
    menu_elem.style.display = "block";
});

close_btn.addEventListener("click", function (event) {
    menu_elem.style.display = "none";
});