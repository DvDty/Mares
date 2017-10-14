function select_color(element) {
    var colors = document.getElementsByClassName("colorsBox");

    for (var i = 0; i < colors.length; i++) {
        colors[i].classList.remove('colorsBox_selected');
    }

    element.classList.add('colorsBox_selected');

    document.getElementsByName("app_bundle_add_to_cart_type[color]")[0].setAttribute('value', element.getAttribute('value'));
}