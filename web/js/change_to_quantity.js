function add_one() {
    q = document.getElementsByClassName("p-quantity-input")[0];
    value = q.getAttribute("value");

    if (value >= 999) {
        return;
    }

    if (value / value != 1) {
        q.setAttribute("value", 1);
        q.value = 1;
        return;
    } else {
        value = parseInt(value);
    }

    q.setAttribute("value", value + 1);
    q.value = value + 1;
}

function decrease_one() {
    q = document.getElementsByClassName("p-quantity-input")[0];
    value = q.getAttribute("value");

    if (value <= 1) {
        q.setAttribute("value", 1);
        q.value = 1;
        return;
    }

    if (value / value != 1) {
        q.setAttribute("value", 1);
        q.value = 1;
        return;
    } else {
        value = parseInt(value);
    }

    q.setAttribute("value", value - 1);
    q.value = value - 1;
}

function change_value(new_value) {
    document.getElementsByClassName("p-quantity-input")[0].setAttribute("value", new_value);
}