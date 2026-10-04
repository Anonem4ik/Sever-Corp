<?php
    session_start();
    require_once __DIR__."\\admin_check.php";
    require_once __DIR__."\\..\\..\\..\\includes\\connect.php";
    require_once __DIR__."\\..\\..\\..\\includes\\static_data.php";
    // Unpacking values
    $table = $_POST['table_name'];
    $id = $_POST['id'];
    $fields = $_POST['fields'];
    // Whitelist for tables
    if (!in_array($table, TABELS_WHITELIST)) {
        header("Location: ../admin_panel.php");
        exit;
    }
    // Forming query
    $sets_list = "";
    foreach ($fields as $column => $value) {
        $formated_value = $value !== "" ? ":$column" : "NULL";
        $sets_list .= "`$column`=$formated_value,";
    }
    $sets_list = substr($sets_list, 0, -1);
    $id_col = IDS_DATA[$table];
    $sql = "UPDATE $table SET $sets_list WHERE `$id_col` = '$id';";
    // Performing updating
    $statement = $pdo->prepare($sql);
    foreach ($fields as $column => $value) {
        if ($value === "") continue;
        $statement->bindValue(":$column", $value);
    }
    $statement->execute();
    // [GOODS] Adding images and additional info for good
    if ($table == 'goods') {
        // Directory and previous images count
        $directory = __DIR__."\\..\\..\\images\\items_images\\";
        $sql = "SELECT `images_count` FROM goods WHERE `good_id` = :id";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $images_count = $statement->fetch()[0];
        // Removing existing images
        $removed_imgs = $_POST['removed_img'] ?? [];
        foreach ($removed_imgs as $img_number) {
            unlink($directory.$id."_".$img_number.".webp");
            for ($i = $img_number + 1; $i <= $images_count; $i++) {
                rename($directory.$id."_".$i.".webp", $directory.$id."_".($i - 1).".webp");
            }
            $images_count--;
        }
        // Adding images on server
        for ($i = 0; $i < count($_FILES['images']['name']); $i++) {
            // Checking if image is present
            if ($_FILES['images']['name'][$i] == '') continue;
            // Checking if it is real image
            if (getimagesize($_FILES['images']["tmp_name"][$i]) === false) continue;
            // Incrementing image counter
            $images_count += 1;
            $temp_name = $_FILES['images']['tmp_name'][$i];
            $file_name = $id."_".($images_count).".webp";
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
        $sql = "UPDATE goods SET `images_count`='$images_count' WHERE `good_id`=:id";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();
        // Removind additional info
        $deleted = $_POST['removed_add_info'] ?? [];
        foreach ($deleted as $info_id) {
            $sql = "DELETE FROM additional_info WHERE `info_id` = :info_id";
            $statement = $pdo->prepare($sql);
            $statement->bindValue(':info_id', $info_id);
            $statement->execute();
        }
        // Updating additional info update_info
        $updated_info = $_POST['updated_info'] ?? ['ids' => [], 'names' => [], 'values' => []];
        $updated = array_map(null, $updated_info['ids'], $updated_info['names'], $updated_info['values']);
        foreach ($updated as [$info_id, $name, $value]) {
            $sql = <<<EOF
            UPDATE additional_info SET `name`=:name, `value`=:value
            WHERE `info_id` = :info_id
            EOF;
            $statement = $pdo->prepare($sql);
            $statement->bindValue(':info_id', $info_id);
            $statement->bindValue(':name', $name);
            $statement->bindValue(':value', $value);
            $statement->execute();
        }
        // Adding additional info
        $add_info_names = $_POST['add_info']['names'] ?? [];
        $add_info_values = $_POST['add_info']['values'] ?? [];
        foreach (array_map(null, $add_info_names, $add_info_values) as [$name, $value]) {
            $sql = <<<EOF
            INSERT INTO additional_info
            (`FK_good`, `name`, `value`)
            VALUES (:id, :name, :value);
            EOF;
            $statement = $pdo->prepare($sql);
            $statement->bindValue(':id', $id);
            $statement->bindValue(':name', $name);
            $statement->bindValue(':value', $value);
            $statement->execute();
        }
    }
    // Returning user
    header("Location: ../admin_panel.php?page=$table");
?>