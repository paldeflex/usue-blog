<?php
require '../config/database.php';

if (isset($_POST['submit'])) {
    // Получить обновленные данные формы
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Проверка на валидацию
    if (!$title || !$description) {
        $_SESSION['edit-category'] = 'Неправильный ввод';
    } else {
        // Обновить категорию
        $query = "UPDATE categories SET title='$title', description='$description' WHERE id='$id' LIMIT 1";
        $result = mysqli_query($connection, $query);

        if (mysqli_errno($connection)) {
            $_SESSION['edit-category'] = "Ошибка при обновлении данных";
        } else {
            $_SESSION['edit-category-success'] = "Данные категории  " . $title . " успешно обновлены!";
        }
    }
}

header('location: ' . ROOT_URL . 'admin/manage-categories.php');
die();