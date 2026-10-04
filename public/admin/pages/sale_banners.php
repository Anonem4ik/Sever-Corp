<?php
    const BANNERS_PATH = "..\\images\\sales_banners\\";
    $banners_num = count(glob(BANNERS_PATH . "*.webp"));
?>

<h2 class="page-header">Баннеры для слайдера на гланной</h2>
<h2 class="page-subheader">Изображения формата ".webp" размером 1440 x 380 px</h2>

<div flex-display="centered-column" class="banners-list">
    <!-- Existing banners -->
    <?php for ($i = 0; $i < $banners_num; $i++) { ?>
    <img src="<?= BANNERS_PATH . "sale_" . $i . ".webp" ?>" alt="Баннер номер <?= $i + 1 ?>" id="img<?= $i ?>">
    <?php } ?>
    <!-- Input for new banner (max 10) -->
    <?php if ($banners_num < 10) { ?>
    <label flex-display="centered-column" class="new-image-input" for="i_new_image">
        <img src="../images/general/cross_icon.svg" alt="Добавить">
        <p>Добавить изображение</p>
    </label>
    <div class="hidden" id="images_info">
        <input id="i_new_image" type="file" name="images[]" accept=".webp">
    </div>
    <?php } ?>
</div>

<!-- Script for adding and delete confirm -->
<script>
    // Elements
    const file_input = document.getElementById("i_new_image");
    const banner_list = document.querySelector(".banners-list");

    // Adding new image
    file_input.addEventListener('change', function(event) {
        // Create new formdata
        const form_data = new FormData();
        form_data.append("image", file_input.files[0]);
        // Sending request
        var request = new XMLHttpRequest();
        request.open("POST", "actions/image_upload.php", false);
        request.send(form_data);
        window.location.reload();
    })

    // Deleting image function
    function delete_me(event) {
        // Asking user confirmation
        if (!window.confirm("Вы точно ходите удалить этот баннер?")) {
            return;
        }
        // Create new formdata
        const form_data = new FormData();
        form_data.append("image_num", event.target.id.substring(3));
        // Sending request
        var request = new XMLHttpRequest();
        request.open("POST", "actions/image_delete.php", false);
        request.send(form_data);
        banner_list.innerHTML += request.response;
        window.location.reload();
    }
    // Appending function to all images
    for (element of banner_list.children) {
        if (element.tagName === 'IMG') {
            element.addEventListener('click', delete_me);
        }
    };
</script>