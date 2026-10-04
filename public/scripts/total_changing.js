// Changing total price
const total_el = document.getElementById("total_price");
function change_total() {
    let total = 0;
    const count_inputs = document.querySelectorAll('.item__count');
    for (const item_i of count_inputs) {
        // Fetching input attributes
        let count = parseInt(item_i.value);
        let price = parseFloat(item_i.getAttribute('price'));
        let wholesale = parseFloat(item_i.getAttribute('wholesale'));
        // Adding to summ
        total += count * (count < 15 ? price : wholesale);
    }
    // Changing total
    total_el.innerText = total.toFixed(2);
}
change_total();
document.querySelectorAll('.item__count').forEach(e => e.addEventListener('change', change_total));