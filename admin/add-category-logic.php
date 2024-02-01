<?php
require '../config/database.php';

if (isset($_POST['submit'])) {
    // get form data
    $title = filter_var($_POST['title'], FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if (!$title) {
        $_SESSION['add-category'] = "Введите заголовок";
    } elseif (!$description) {
        $_SESSION['add-category'] = "Введите описание";
    }

    // Перенаправление к странице "Добавить категорию" с сохранением данных в форме, если были какие-то ошибки
    if (isset($_SESSION['add-category'])) {
        $_SESSION['add-category-data'] = $_POST;
        header('location: ' . ROOT_URL . 'admin/add-category.php');
    } else {
        // Вставка категории в базу данных
        $query = "INSERT INTO categories (title, description) VALUES ('$title', '$description')";
        $result = mysqli_query($connection, $query);
        if (mysqli_errno($connection)) {
            $_SESSION['add-category'] = "Невозможно добавить категорию";
            header('location: ' . ROOT_URL . 'admin/add-category.php');
        } else {
            $_SESSION['add-category-success'] = "Категория " . $title . " успешно добавлена";
            header('location: ' . ROOT_URL . 'admin/manage-categories.php');
        }
    }
    die();
}