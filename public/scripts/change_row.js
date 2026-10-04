// Function that turn table row into form
function prepare_changing() {
    let is_changing = false;

    function perform_changing(row_id, unrequired = []) {
        // Checking if changing is performed
        if (is_changing) return;
        else is_changing = true;
        // Adding info_id value
        document.getElementById('change_form').lastElementChild.value = row_id;
        // Base input
        const i_base = document.createElement("input");
        i_base.setAttribute("form", 'change_form');
        i_base.type = "text";
        i_base.required = "required";
        // Replacing text with inputs
        const row_el = document.getElementById("row_" + row_id);
        for (let att_el of row_el.children) {
            if (parseInt(att_el.getAttribute('is_data')) == 0) continue;
            let att_name = att_el.classList[0].substring(2);
            const td_element = row_el.querySelector(".__" + att_name);
            const input_element = i_base.cloneNode();
            input_element.name = `fields[${att_name}]`;
            input_element.value = td_element.textContent;
            if (unrequired.includes(att_name)) input_element.required = '';
            td_element.replaceChildren(input_element);
        }
        // Create submit button
        const input_submit = document.createElement("input");
        input_submit.setAttribute("form", 'change_form');
        input_submit.type = "submit";
        input_submit.value = "Подтвердить";
        row_el.querySelector('.__change-btn').replaceChildren(input_submit);
    }

    return perform_changing;
}