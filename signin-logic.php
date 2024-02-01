<?php
require 'config/database.php';

if (isset($_POST['submit'])) {
    // Получить данные с формы
    $usernameEmail = filter_var($_POST['username_email'], FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_SPECIAL_CHARS);

    if (!$usernameEmail) {
        $_SESSION['signin'] = 'Необходимо ввести имя пользователя или электронную почту';
    } elseif (!$password) {
        $_SESSION['signin'] = 'Необходим пароль';
    } else {
        // Извлечь пользователя из базы данных
        $fetchUserQuery = "SELECT * FROM users WHERE username='$usernameEmail' OR email='$usernameEmail'";
        $fetchUserResult = mysqli_query($connection, $fetchUserQuery);

        if (mysqli_num_rows($fetchUserResult) == 1) {
            // Преобразовать запись в массив
            $userRecord = mysqli_fetch_assoc($fetchUserResult);
            $dbPassword = $userRecord['password'];
            // Сравнить пароли формы и базы данных
            if (password_verify($password, $dbPassword)) {
                // Установить сессию для управления доступом
                $_SESSION['user-id'] = $userRecord['id'];
                // Установить сессию если пользователь администратор
                if ($userRecord['is_admin'] == 1) {
                    $_SESSION['user_is_admin'] = true;
                }

                // Вход в админку
                header('location: ' . ROOT_URL . 'admin/');
            } else {
                $_SESSION['signin'] = "Введены некорректные данные";
            }
        } else {
            $_SESSION['signin'] = "Пользователь не найден";
        }
    }

    // Если проблема с подключением, то редирект обратно
    if (isset($_SESSION['signin'])) {
        $_SESSION['signin-data'] = $_POST;
        header('location: ' . ROOT_URL . 'signin.php');
        die();
    }

} else {
    header('location: ' . ROOT_URL . 'signin.php');
    die();
}