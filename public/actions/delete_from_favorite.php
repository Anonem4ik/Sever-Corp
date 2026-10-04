<?php
    session_start();
    require_once __DIR__."\\..\\..\\includes\\connect.php";
    require_once __DIR__."\\..\\..\\includes\\dbQueries.php";
    // Check if request was send from appropriate POST form
    if (!isset($_POST['AJAX_request'])) {
        http_response_code(403);
        exit;
    }
    // Check if user is registered
    if (!isset($_SESSION['user_data'])) {
        header("Location: ../login.php");
        exit;
    }
    // Check if id present
    if (!isset($_POST['id'])) {
        http_response_code(406);
        exit;
    }
    $good_id = $_POST['id'];
    // Deleting from favorite
    $user_id = $_SESSION['user_data']['uid'];
    delete_data($pdo, 'favorite_lists', ['FK_user' => $user_id, 'FK_good' => $good_id]);