document.addEventListener("DOMContentLoaded", function () {
    // Changing images
    const img_list = document.querySelectorAll(".side-images");
    const main_img = document.getElementById("selected_img");

    function changeImage(event) {
        main_img.src = this.src;
    }
    img_list.forEach((img) => { img.addEventListener('click', changeImage) })

    // Sliding trough images
    const scroll_area = document.getElementById("scroll_area");
    const scroll_container = document.getElementById("scroll_container");
    const direction = scroll_area.clientWidth > scroll_area.clientHeight ? "X" : "Y";
    let limit = -1;
    if (direction == "Y") limit *= (scroll_area.scrollHeight - scroll_container.clientHeight);
    else limit *= (scroll_area.scrollWidth - scroll_container.clientWidth);
    const step = 100;
    let current_pos = 0;
    
    const scroll_up = document.getElementById("scroll_up");
    const scroll_down = document.getElementById("scroll_down");
    if (scroll_up) {
        scroll_up.addEventListener("click", function() {
            current_pos += step;
            if (current_pos > 0) current_pos = 0;
            scroll_area.style.transform = `translate${direction}(${current_pos}px)`;
        });
    }
    if (scroll_down) {
        document.getElementById("scroll_down").addEventListener("click", function() {
            current_pos -= step;
            if (current_pos < limit) current_pos = limit;
            scroll_area.style.transform = `translate${direction}(${current_pos}px)`;
        });
    }

    // Rating stars handling
    const rating_input = document.getElementById("i_rating");
    const stars_list = document.querySelectorAll(".rating-star");
    let rating = 5;

    function proceedRating(event) {
        rating = this.id.substring(1);
        rating_input.value = rating;
        
        for (star_img of stars_list) {
            if (star_img.id.substring(1) <= rating) {
                star_img.src = "./images/general/full_star.svg";
            } else {
                star_img.src = "./images/general/hollow_star.svg";
            }
        }
    }
    stars_list.forEach((star_img) => { star_img.addEventListener('click', proceedRating) });
});