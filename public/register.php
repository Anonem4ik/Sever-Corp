<?php
    session_start();
    require_once __DIR__."\\..\\includes\\connect.php";
    require_once __DIR__."\\..\\includes\\dbQueries.php";
    // Check if user already logged in
    if (isset($_SESSION['user_data'])) {
        header("Location: /");
        exit;
    }
    if (isset($_POST['submit'])) {
        // Unpack fields
        $login = $_POST['login'];
        $password = $_POST['password'];
        $pwd_repeat = $_POST['pwd_repeat'];
        $email = $_POST['email'];
        // Fields validation
        if ($login == '' or $password == '' or $email == '') {
            // Check if all fields are set
            $_SESSION['error_message'] = 'Заполните все поля!';
        } else if (!isset($_POST['agreement'])) {
            // Check if agreement are true
            $_SESSION['error_message'] = 'Требуется согласие на обработку персональных данных.';
        } else if ($password != $pwd_repeat) {
            // Check if passwords are same
            $_SESSION['error_message'] = 'Пароли не совпадают.';
        } else {
            try {
                // Trying to add user
                $password = md5($password);
                insert_data($pdo, 'users', ['login' => $login, 'email' => $email, 'password' => $password]);
                // Create user basket
                $user_id = getBy($pdo, 'users', ['login' => $login, 'password' => $password])['user_id'];
                insert_data($pdo, 'orders', ['FK_user' => $user_id]);
                header('Location: ../login.php');
            } catch (PDOException $e) {
                // If login already exists
                if ($e->getCode() === '23000') {
                    $email_q = getBy($pdo, 'users', ['email' => $email]);
                    if (!$email_q) {
                        $_SESSION['error_message'] = "Это имя уже занято! Приумайте другое.";
                    } else {
                        $_SESSION['error_message'] = "Эта электронная почта уже зарегестрирована!";
                    }
                } else {
                    throw $e;
                }
            }
        }
    }
    // Preparing output data
    $page_title = 'Регистрация';
    ob_start();
    include __DIR__.'\\..\\templates\\register.html.php';
    $page_content = ob_get_clean();
    // Displaying page to user
    include __DIR__.'\\..\\templates\\blank_layout.html.php';
?>
