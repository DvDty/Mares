function update_colors(product_id){
    var colors = document.getElementsByClassName("colorsBox_selected");
    var selected = [];

    for (var i = 0; i < colors.length; i++) {
        selected.push(colors[i].getAttribute('value'));
    }

    window.location = "/admin/product/color/set/" + selected.toString() + "/" + product_id;
}