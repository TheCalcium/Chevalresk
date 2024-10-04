$(document).ready(function () {

    // Menu
    let menu_btn = document.querySelector("#menu-btn");
    let burger_icon = document.querySelector("#burger-icon");
    let menu_container = document.querySelector(".menu");

    menu_btn.addEventListener("click", function () {
        burger_icon.classList.toggle("open");
        menu_container.classList.toggle("menu-visible");
    });

    // Admin Menu
    let menu_admin = document.querySelector(".menu-admin");

    if (menu_admin != null) {
        let admin_btn = document.querySelector("#menu-admin-btn");
        let admin_btn_arrow = document.querySelector("#menu-admin-btn-arrow");

        admin_btn.addEventListener("click", function () {
            let arrow_name = (menu_admin.classList.contains("hidden")) ? "chevron-down-outline" : "chevron-forward-outline";
            admin_btn_arrow.setAttribute("name", arrow_name);
            menu_admin.classList.toggle("hidden");
        });
    }
});