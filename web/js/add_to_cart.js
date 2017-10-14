function add_to_cart() {
    var check = true;

    if (document.getElementsByClassName("colorsBox_selected")[0] == undefined) {
        check = false;
        document.getElementById("show_error_color").style.display = "";
    } else {
        document.getElementById("show_error_color").style.display = "none";
    }

    if (document.getElementsByClassName("size-selected")[0] == undefined) {
        check = false;
        document.getElementById("show_error_size").style.display = "";
    } else {
        document.getElementById("show_error_size").style.display = "none";
    }

    var quantity_value = document.getElementById("app_bundle_add_to_cart_type_quantity").value;

    if (isNaN(quantity_value) || quantity_value < 1 || quantity_value > 999) {
        check = false;
        document.getElementById("show_error_quantity").style.display = "";
    } else {
        document.getElementById("show_error_quantity").style.display = "none";
    }

    if (check) {
        document.getElementsByName("app_bundle_add_to_cart_type")[0].submit();
    }
}