<?php
require '../config/database.php';

if (isset($_POST['submit'])) {
    // Получить обновленные данные формы
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $firstName = filter_var($_POST['first_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastName = filter_var($_POST['last_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_admin = filter_var($_POST['user_role'], FILTER_SANITIZE_NUMBER_INT);

    // Проверка на валидацию
    if (!$firstName || !$lastName) {
        $_SESSION['edit-user'] = 'Неправильный ввод';
    } else {
        // Обновить пользователя
        $query = "UPDATE users SET first_name='$firstName', last_name='$lastName', is_admin='$is_admin' WHERE id='$id' LIMIT 1";
        $result = mysqli_query($connection, $query);

        if (mysqli_errno($connection)) {
            $_SESSION['edit-user'] = "Ошибка при обновлении данных";
        } else {
            $_SESSION['edit-user-success'] = "Данные пользователя  " . $firstName . " " . $lastName . " успешно обновлены!";
        }
    }
}

header('location: ' . ROOT_URL . 'admin/manage-users.php');
die();