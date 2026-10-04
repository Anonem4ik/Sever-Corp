<?php
    session_start();
    require_once __DIR__."\\admin_check.php";
    // Unpacking and sanitizing fields
    $metrics = $_POST['metrics'] ?? ['names' => [], 'valeus' => []];
    $description = $_POST['description'];
    $snippets = $_POST['snippets'];
    $changed_images = $_POST['changed_images'] ?? [];
    $images = $_FILES['images'];
    // Sanitizing fields
    $s_description = $description;
    $s_metrics = [];
    foreach (array_map(null, $metrics['names'], $metrics['values']) as $record) {
        $s_metrics[] = [
            'name' => $record[0],
            'value' => $record[1]
        ];
    }
    $s_snippets = [];
    foreach ($snippets as $record) {
        $s_snippets[] = $record;
    }
    $s_changed_images = [];
    foreach ($changed_images as $record) {
        $s_changed_images[] = intval($record);
    }
    // Forming json object and sending it
    $data_to_save = [
        'metrics' => $s_metrics,
        'company_description' => $s_description,
        'snippets' => $snippets
    ];
    $encoded_data = json_encode($data_to_save, JSON_PRETTY_PRINT);
    file_put_contents("..\\..\\..\\json\\about_company.json", $encoded_data, LOCK_EX);
    // Chinging images
    foreach ($s_changed_images as $image_num) {
        // Checking if image is present
        if ($images['name'][$image_num] == '') continue;
        // Checking if it is real image
        if (getimagesize($images["tmp_name"][$image_num]) === false) continue;
        // Images names
        $temp_name = $images['tmp_name'][$image_num];
        $file_name = "snippet_image_".$image_num.".webp";
        // Addimg image and converting if necesary
        $directory = "..\\..\\images\\history_images\\";
        switch ($images['type'][$image_num]) {
            case "image/png":
                $image_gd = imagecreatefrompng($temp_name);
                imagesavealpha($image_gd, true);
                imagewebp($image_gd, $directory.$file_name, -1);
                unset($image_gd);
                break;
            case "image/jpeg":
                $image_gd = imagecreatefromjpeg($temp_name);
                imagewebp($image_gd, $directory.$file_name, -1);
                unset($image_gd);
                break;
            case "image/webp":
                move_uploaded_file($temp_name, $directory.$file_name);
                break;
            default:
                continue 2;
        }
    }
    // Redirecting user
    header("Location: ../admin_panel.php?page=about");
?>