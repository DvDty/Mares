function update_sizes(product_id){
    var sizes = document.getElementsByClassName("size-selected");
    var selected = [];

    for (var i = 0; i < sizes.length; i++) {
        selected.push(sizes[i].getAttribute('value'));
    }

    window.location = "/admin/product/size/set/" + selected.toString() + "/" + product_id;
}