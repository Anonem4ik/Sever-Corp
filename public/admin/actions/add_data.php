<?php
    session_start();
    require_once __DIR__."\\admin_check.php";
    require_once __DIR__."\\..\\..\\..\\includes\\connect.php";
    require_once __DIR__."\\..\\..\\..\\includes\\static_data.php";
    // Unpacking values
    $table = $_POST['table_name'];
    $fields = $_POST['fields'];
    // Whitelist for tables
    if (!in_array($table, TABELS_WHITELIST)) {
        header("Location: ../admin_panel.php");
        exit;
    }
    // Forming query
    $columns_list = $values_list = "";
    foreach ($fields as $column => $value) {
        $columns_list .= "`$column`, ";
        $values_list .= $value !== "" ? ":$column, " : "NULL, ";
    }
    $columns_list = substr($columns_list, 0, -2);
    $values_list = substr($values_list, 0, -2);
    $sql = "INSERT INTO $table ($columns_list) VALUES ($values_list);";
    // Performing adding
    $statement = $pdo->prepare($sql);
    foreach ($fields as $column => $value) {
        if ($value === "") continue;
        $statement->bindValue(":$column", $value);
    }
    $statement->execute();
    // [GOODS] Adding images and additional info for good
    if ($table == 'goods') {
        $good_id = $pdo->lastInsertId();
        // Adding images on server
        $directory = __DIR__."\\..\\..\\images\\items_images\\";
        $images_count = 0;
        for ($i = 0; $i < count($_FILES['images']['name']); $i++) {
            // Checking if image is present
            if ($_FILES['images']['name'][$i] == '') continue;
            // Checking if it is real image
            if (getimagesize($_FILES['images']["tmp_name"][$i]) === false) continue;
            // Incrementing image counter
            $images_count += 1;
            $temp_name = $_FILES['images']['tmp_name'][$i];
            $file_name = $good_id."_".($images_count).".webp";
            // Addimg image and converting if necesary
            switch ($_FILES['images']['type'][$i]) {
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
        // Updating image count
        $sql = "UPDATE goods SET `images_count`='$images_count' WHERE `good_id`='$good_id'";
        $pdo->exec($sql);
        // Adding additional info
        $add_info_names = $_POST['add_info']['names'] ?? [];
        $add_info_values = $_POST['add_info']['values'] ?? [];
        foreach (array_map(null, $add_info_names, $add_info_values) as [$name, $value]) {
            $sql = "INSERT INTO additional_info (`FK_good`, `name`, `value`) VALUES ('$good_id', :name, :value)";
            $statement = $pdo->prepare($sql);
            $statement->bindValue(':name', $name);
            $statement->bindValue(':value', $value);
            $statement->execute();
        }
    }
    // Returning user
    header("Location: ../admin_panel.php?page=$table");
?>