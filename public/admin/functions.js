// Names for page-dependent variables
let table_name = '';
let fields_data = [];
// Global flag for restricting changing
let is_cahnging = false;

// Adding wiget
function convert_to_form(id) {
    // Check and flip flag
    if (is_cahnging) return;
    else is_cahnging = true;
    // Getting wiget
    const wiget = document.getElementById("wiget" + id.toString());
    // If changing, find previous values
    let prev_values = [];
    if (id !== 0) {
        let prev_text = wiget.getElementsByClassName('wiget__text')[0].textContent.replace(/\s+/g, " ").trim();
        console.log(prev_text);
        if (table_name == 'categories') {
            prev_values.push(prev_text);
        } else if (table_name == 'shippers') {
            let end = prev_text.indexOf('(') != -1 ? prev_text.indexOf('(') - 1 : prev_text.length;
            prev_values.push(prev_text.slice(0, end));
            prev_values.push(prev_text.slice(end + 2, prev_text.length - 1));
        } else if (table_name == 'special_offers') {
            let end = prev_text.indexOf('-');
            prev_values.push(prev_text.slice(0, end - 1));
            prev_values.push(prev_text.slice(end + 2, prev_text.length - 1));
        }
    }
    // Clearing wiget
    wiget.replaceChildren();
    // Creating new button
    const submit_button = document.createElement("button");
    submit_button.classList = "clear-button";
    let img_el = '';
    if (id === 0) img_el = '<img class="wiget__icon" src="../../images/general/cross_icon.svg" alt="Подтвердить">';
    else img_el = '<img class="wiget__icon" src="../../images/general/pencil_icon.svg" alt="Изменить">';
    submit_button.innerHTML = img_el;
    wiget.appendChild(submit_button);
    // Hidden inputs
    wiget.innerHTML += `<input type="hidden" name="table_name" value="${table_name}">`;
    if (id !== 0) wiget.innerHTML += `<input type="hidden" name="id" value="${id}">`;
    // Creating base input
    const base_input = document.createElement("input");
    base_input.classList = "wiget__input";
    // Itarating trough all inputs
    fields_data.forEach((field, i) => {
        const new_input = base_input.cloneNode();
        new_input.type = field.type;
        if (field.type == 'number') new_input.step = '0.01';
        new_input.name = `fields[${field.name}]`;
        if (id !== 0) new_input.value = prev_values[i];
        new_input.required = field.required ? "required" : "";
        wiget.appendChild(new_input);
    })
}

// Deleting alert
function confirm_deletion(id) {
    if (!window.confirm("Вы точно ходите удалить этот элемент?")) return;
    else location.replace(`actions/remove_data.php?table_name=${table_name}&id=${id}`);
}

// Adding to get querry
function update_get_query(param_name, value) {
    var searchParams = new URLSearchParams(window.location.search);
    if (value != '')
        searchParams.set(param_name, value);
    else
        searchParams.delete(param_name);
    window.location.search = searchParams.toString();
}