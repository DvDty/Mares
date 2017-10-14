function toggle_color(element) {
    if (element.classList.contains('colorsBox_selected')) {
        element.classList.remove('colorsBox_selected');
    } else {
        element.classList.add('colorsBox_selected');
    }
}