<?php
require '../config/database.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    $update_query = "UPDATE posts SET category_id=20 WHERE category_id='$id'";
    $update_result = mysqli_query($connection, $update_query);

    if (!mysqli_errno($connection)) {
        // Удалить пользователя из базы данных
        $deleteCategoryQuery = "DELETE FROM categories WHERE id=$id";
        $deleteCategoryResult = mysqli_query($connection, $deleteCategoryQuery);
        if (mysqli_errno($connection)) {
            $_SESSION['delete-category'] = "Невозможно удалить категорию";
        } else {
            $_SESSION['delete-category-success'] = "Удаление категории произошло успешно";
        }
    }
}

header('location: ' . ROOT_URL . 'admin/manage-categories.php');
die();