// Slider control
const slider = document.getElementById("slider_moving");
const radio_list = document.querySelectorAll("input[name=\"slider_control\"]");

function move_to(event) {
    slider.style.transform = `translate(-${parseInt(this.value) * 100}%)`;
}

for (const radio of radio_list) {
    radio.addEventListener('change', move_to)
}