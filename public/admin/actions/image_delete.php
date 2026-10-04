<?php
    // Directory to upload
    const BANNERS_PATH = __DIR__."\\..\\..\\images\\sales_banners\\";
    // Unpacking fields
    $image_num = $_POST['image_num'];
    // Counting images
    $banners_num = count(glob(BANNERS_PATH . "*.webp"));
    // Deleting image
    unlink(BANNERS_PATH."sale_".$image_num.".webp");
    // Shifting images names
    for ($i = $image_num + 1; $i < $banners_num; $i++) {
        rename(BANNERS_PATH."sale_".$i.".webp", BANNERS_PATH."sale_".($i - 1).".webp");
    }
?>