<?php
    session_start();
    // Directory to upload
    const BANNERS_PATH = __DIR__."\\..\\..\\images\\sales_banners\\";
    // Checking if it is real image
    if (getimagesize($_FILES['image']["tmp_name"]) === false) {
        $_SESSION['error_message'] = "Загруженый вами файл не является изображением!";
        exit;
    };
    // Checking for valid type
    if ($_FILES['image']['type'] != "image/webp") {
        $_SESSION['error_message'] = "Поддерживаются изображения только в формате WEBP!";
        exit;
    };
    // Counting images
    $banners_num = count(glob(BANNERS_PATH . "*.webp"));
    // Adding image
    $file_name = "sale_".($banners_num).".webp";
    move_uploaded_file($_FILES['image']['tmp_name'], BANNERS_PATH.$file_name);
?>