<?php
    session_start();
    require_once __DIR__."\\..\\includes\\connect.php";
    require_once __DIR__."\\..\\includes\\dbQueries.php";
    // Check if user already logged in
    if (isset($_SESSION['user_data'])) {
        header("Location: /");
        exit;
    }
    // Process login
    if (isset($_POST['submit'])) {
        // Unpack fields
        $login = $_POST['login'];
        $password = md5($_POST['password']);
        // Finding user in database
        $user = getBy($pdo, 'users', ['login' => $login, 'password' => $password]);
        // Check if user with this combination exist
        if (!$user) {
            // If not, display error message
            $_SESSION['error_message'] = 'Неверный логин или пароль!';
        } else {
            // Setup session
            $_SESSION['user_data'] = [
                'uid' => $user['user_id'],
                'login' => $user['login'],
                'email' => $user['email']
            ];
            header('Location: /');
            exit;
        }
    }
    // Preparing output data
    $page_title = 'Авторизация';
    ob_start();
    include __DIR__.'\\..\\templates\\login.html.php';
    $page_content = ob_get_clean();
    // Displaying page to user
    include __DIR__.'\\..\\templates\\blank_layout.html.php';
?>