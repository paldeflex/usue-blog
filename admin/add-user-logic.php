<?php
require '../config/database.php';

const PASSWORD_LENGHT = 6;
const ALLOWED_IMAGE_SIZE = 1048576;

// Получение данных по нажатию на кнопку формы
if (isset($_POST['submit'])) {
    $firstName = filter_var($_POST['first_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastName = filter_var($_POST['last_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $passwordConfirm = filter_var($_POST['password_confirm'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_admin = filter_var($_POST['user_role'], FILTER_SANITIZE_NUMBER_INT);
    $profilePic = $_FILES['profile_pic'];

    // Валдиация полей
    if (!$firstName) {
        $_SESSION['add-user'] = 'Пожалуйста, введите имя';
    } elseif (!$lastName) {
        $_SESSION['add-user'] = 'Пожалуйста, введите фамилию';
    } elseif (!$username) {
        $_SESSION['add-user'] = 'Пожалуйста, введите имя пользователя';
    } elseif (!$email) {
        $_SESSION['add-user'] = 'Пожалуйста, введите электронную почту';
    } elseif (strlen($password) < PASSWORD_LENGHT) {
        $_SESSION['add-user'] = 'Пароль должен состоять минимум из ' . PASSWORD_LENGHT . ' символов';
    } elseif (!$profilePic['name']) {
        $_SESSION['add-user'] = 'Пожалуйста, загрузите изображение';
    } else {
        // Проверка если пароли не совпадают
        if ($password !== $passwordConfirm) {
            $_SESSION['add-user'] = 'Пароли не совпадают';
        } else {
            // Зашифровать пароль
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Проверка является ли логин или электронная почта уже в базе данных
            $userCheckQuery = "SELECT * FROM users WHERE username='$username' OR email='$email'";
            $userCheckResult = mysqli_query($connection, $userCheckQuery);
            if (mysqli_num_rows($userCheckResult) > 0) {
                $_SESSION['add-user'] = "Имя пользователя или электронная почта уже используется";
            } else {
                // Работа с изображением пользователя
                // Переименовать изображение пользователя
                $time = time(); // Сделать каждое изображение уникальных используя текущее время
                $profilePicName = $time . $profilePic['name'];
                $profilePicTmpName = $profilePic['tmp_name'];
                $profilePicDestinationPath = '../assets/images/' . $profilePicName;

                // Убедиться что файл это изображение
                $allowedFiles = ['png', 'jpg', 'jpeg'];
                $allowedFilesFormats = implode(', ', $allowedFiles);
                $extension = explode('.', $profilePicName);
                $extension = end($extension);
                if (in_array($extension, $allowedFiles)) {
                    // Убедиться что размер файла не слишком большой
                    if ($profilePic['size'] < ALLOWED_IMAGE_SIZE) {
                        // Загрузка изображения пользователя
                        move_uploaded_file($profilePicTmpName, $profilePicDestinationPath);
                    } else {
                        $_SESSION['add-user'] = 'Размер файла слишком большой. Файл должен быть меньше чем ' . (ALLOWED_IMAGE_SIZE / 1024 / 1024) . 'мб.';
                    }
                } else {
                    $_SESSION['add-user'] = "Файл должен быть следующих форматов: " . $allowedFilesFormats;
                }
            }
        }
    }
    // Редирект к странице регистрации, если есть какие-то проблемы
    if ($_SESSION['add-user']) {
        $_SESSION['add-user-data'] = $_POST;
        header('location: ' . ROOT_URL . 'admin/add-user.php');
        die();
    } else {
        // Вставка нового пользователя в таблицу пользователей
        $insertUserQuery = "INSERT INTO users (first_name, last_name, username, email, password, profile_pic, is_admin)
                    VALUES('$firstName', '$lastName', '$username', '$email', '$hashedPassword', '$profilePicName', $is_admin)";
        $insertUserResult = mysqli_query($connection, $insertUserQuery);

        if (!mysqli_errno($connection)) {
            // Редирект к странице пользователя и сообщении об успехе
            $_SESSION['add-user-success'] = "Пользователь ". $username . " успешно добавлен!";
            header('location: ' . ROOT_URL . 'admin/manage-users.php');
            die();
        }
    }
} else {
    // Если кнопка не была нажата, возвращаемся обратно на страницу регистрации
    header('location: ' . ROOT_URL . 'admin/add-user.php');
    die();
}