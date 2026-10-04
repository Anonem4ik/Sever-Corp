function change_basket(event, action, id) {
    // Forming FormData
    let form_data = new FormData();
    form_data.append('AJAX_request', 'on');
    form_data.append('id', id);
    // Sending request
    var request = new XMLHttpRequest();
    request.open("POST", `actions/${action === 'add' ? 'add_to' : 'delete_from'}_basket.php`, false);
    request.send(form_data);
    // Changing button
    if (request.status === 200) {
        // On sucess, change button
        if (action === 'add') {
            const span = document.createElement('span');
            span.innerText = "В корзине";
            span.classList.add("in-basket");
            span.classList.add("f-16");
            event.target.replaceWith(span);
        } else {
            const basket_card = event.target.parentElement.parentElement;
            basket_card.replaceChildren();
            basket_card.remove();
            change_total();
        }
    } else {
        // On error, display message
        alert("Что-то пошло не так.\nПовторите попытку позже.");
    }
}

function change_favorite(event, action, id, is_item_btn = false) {
    // Forming FormData
    let form_data = new FormData();
    form_data.append('AJAX_request', 'on');
    form_data.append('id', id);
    // Sending request
    var request = new XMLHttpRequest();
    request.open("POST", `actions/${action === 'add' ? 'add_to' : 'delete_from'}_favorite.php`, false);
    request.send(form_data);
    console.log(request.response);
    console.log(request.status);
    // Changing button
    if (request.status === 200) {
        // On sucess, change appearance and function
        if (!is_item_btn) {
            // For product card
            const img = event.target;
            const btn = img.parentElement;
            if (action === 'add') {
                img.src = "/images/general/full_star.svg";
                btn.onclick = (new_event) => { change_favorite(new_event, 'delete', id) }
            } else {
                img.src = "/images/general/hollow_star.svg";
                btn.onclick = (new_event) => { change_favorite(new_event, 'add', id) }
            }
            img.classList.toggle('in-favorite');
            img.classList.toggle('to-favorite');
        } else {
            // For item page
            const span = document.createElement('span');
            span.innerText = "В избранном";
            span.classList.add("in-basket");
            span.classList.add("f-16");
            event.target.replaceWith(span);
        }
    } else {
        // On error, display message
        alert("Что-то пошло не так.\nПовторите попытку позже.");
    }
}