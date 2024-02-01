<?php
require '../config/database.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Извлечь пользователя из БД
    $query = "SELECT * FROM users WHERE id='$id' ";
    $result = mysqli_query($connection, $query);

    // Убедимся что получаем только одного пользователя
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $profilePic = $user['profile_pic'];
        $profilePicPath = '../assets/images/' . $profilePic;
        // Удалить изображение, если есть
        if ($profilePicPath) {
            unlink($profilePicPath);

            // Извлечь все изображения постов пользователя и удалить их
            $thumbnails_query = "SELECT thumbnail FROM posts WHERE author_id='$id'";
            $thumbnails_result = mysqli_query($connection, $thumbnails_query);
            if (mysqli_num_rows($thumbnails_result) > 0) {
                while ($thumbnail = mysqli_fetch_assoc($thumbnails_result)) {
                    $thumbnail_path = '../assets/images/' . $thumbnail['thumbnail'];
                    // Удаление картинки
                    if ($thumbnail_path) {
                        unlink($thumbnail_path);
                    }
                }
            }


            // Удалить пользователя из базы данных
            $deleteUserQuery = "DELETE FROM users WHERE id=$id";
            $deleteUserResult = mysqli_query($connection, $deleteUserQuery);
            if (mysqli_errno($connection)) {
                $_SESSION['delete-user'] = "Невозможно удалить пользователя";
            } else {
                $_SESSION['delete-user-success'] = "Удаление пользователя " . $user['username'] . " произошло успешно";
            }
        }
    }
}

header('location: ' . ROOT_URL . 'admin/manage-users.php');
die();