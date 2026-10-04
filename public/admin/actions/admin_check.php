<?php
    // Check if user is admin
    if (!isset($_SESSION['user_data']) || ($_SESSION['user_data']['uid'] ?? null) != 6) {
        http_response_code(301);
        header("Location: /");
        exit;
    }
?>