<?php
require '../config/database.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Извлечь категорию из БД
    $query = "SELECT * FROM posts WHERE id='$id' ";
    $result = mysqli_query($connection, $query);

    // Убедимся что получаем только одного пользователя
    if (mysqli_num_rows($result) == 1) {
        $post = mysqli_fetch_assoc($result);
        $thumbnail_name = $post['thumbnail'];
        $thumbnail_path = '../assets/images/' . $thumbnail_name;
        // Удалить изображение, если есть
        if ($thumbnail_path) {
            unlink($thumbnail_path);

            // Удалить статью из базы данных
            $deletePostQuery = "DELETE FROM posts WHERE id=$id";
            $deletePostResult = mysqli_query($connection, $deletePostQuery);
            if (mysqli_errno($connection)) {
                $_SESSION['delete-post'] = "Невозможно удалить статью";
            } else {
                $_SESSION['delete-post-success'] = "Удаление статьи произошло успешно";
            }
        }
    }
}

header('location: ' . ROOT_URL . 'admin/');
die();