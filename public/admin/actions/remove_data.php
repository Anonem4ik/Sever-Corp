<?php
    session_start();
    require_once __DIR__."\\admin_check.php";
    require_once __DIR__."\\..\\..\\..\\includes\\connect.php";
    require_once __DIR__."\\..\\..\\..\\includes\\static_data.php";
    // Unpacking values
    $table = $_GET['table_name'];
    $id = $_GET['id'];
    // Whitelist for tables
    if (!in_array($table, TABELS_WHITELIST)) {
        header("Location: ../admin_panel.php");
        exit;
    }
    // [GOODS] Removing images
    if ($table == 'goods') {
        $sql = "SELECT `images_count` FROM goods WHERE `good_id` = :good_id";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':good_id', $id);
        $statement->execute();
        $images_count = $statement->fetch()[0];
        $directory = "..\\..\\images\\items_images\\";
        for ($i = 1; $i <= $images_count; $i++) {
            unlink($directory.$id."_".$i.".webp");
        }
    }
    // Forming query
    $id_col = IDS_DATA[$table];
    $sql = "DELETE FROM $table WHERE `$id_col` = :id";
    try {
        // Performing deletion
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();
    } catch (PDOException $e) {
        // If data had restrictions, abort and show error message
        if ($e->errorInfo[1] === 1451) {
            $msg = "Невозможно удалить этот элемент, так как он используется в других местах!";
            $_SESSION['error_message'] = $msg;
        } else {
            throw $e;
        }
    } finally {
        // Returning user
        header("Location: ../admin_panel.php?page=$table");
    }
?>