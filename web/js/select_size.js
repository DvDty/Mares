function select_size(element) {
    var sizes = document.getElementsByClassName("size");

    for (var i = 0; i < sizes.length; i++) {
        sizes[i].classList.remove('size-selected');
    }

    element.classList.add('size-selected');

    document.getElementsByName("app_bundle_add_to_cart_type[size]")[0].setAttribute('value', element.getAttribute('value'));
}