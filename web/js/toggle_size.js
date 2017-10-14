function toggle_size(element) {
    if (element.classList.contains('size-selected')) {
        element.classList.remove('size-selected');
    } else {
        element.classList.add('size-selected');
    }
}