<?php
require '../config/database.php';

const ALLOWED_IMAGE_SIZE = 1048576;

if (isset($_POST['submit'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $previous_thumbnail_name = filter_var($_POST['previous_thumbnail_name']);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $thumbnail = $_FILES['thumbnail'];

    $is_featured = $is_featured == 1 ? 1 : 0;

    // Проверка на валидацию
    if (!$title || !$body || !$category_id) {
        $_SESSION['edit-post'] = "Невозможно отредактировать статью. Введены некорректные данные";
    } else {
        // Обработка нового изображения
        if ($thumbnail['name']) {
            $time = time();
            $new_thumbnail_name = $time . basename($thumbnail['name']);
            $thumbnail_tmp_name = $thumbnail['tmp_name'];
            $thumbnail_destination_path = '../assets/images/' . $new_thumbnail_name;

            // Проверки на тип и размер файла
            $allowedFiles = ['png', 'jpg', 'jpeg'];
            $extension = pathinfo($thumbnail['name'], PATHINFO_EXTENSION);
            if (in_array($extension, $allowedFiles) && $thumbnail['size'] < ALLOWED_IMAGE_SIZE) {
                if (move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path)) {
                    // Удаление старого изображения
                    $previous_thumbnail_path = '../assets/images/' . $previous_thumbnail_name;
                    if (file_exists($previous_thumbnail_path)) {
                        unlink($previous_thumbnail_path);
                    }
                    $thumbnail_to_insert = $new_thumbnail_name;
                } else {
                    $_SESSION['edit-post'] = "Ошибка при загрузке файла.";
                }
            } else {
                $_SESSION['edit-post'] = "Файл должен быть в формате png, jpg, jpeg и размером меньше чем " . (ALLOWED_IMAGE_SIZE / 1024 / 1024) . " мб.";
            }
        } else {
            // Если новое изображение не загружено, используем старое
            $thumbnail_to_insert = $previous_thumbnail_name;
        }

        if (empty($_SESSION['edit-post'])) {
            // Если устанавливается is_featured, сбросить его у всех статей
            if ($is_featured == 1) {
                $reset_featured_query = "UPDATE posts SET is_featured = 0";
                mysqli_query($connection, $reset_featured_query);
            }

            // Обновление записи в базе данных
            $query = "UPDATE posts SET title=?, body=?, thumbnail=?, category_id=?, is_featured=? WHERE id=?";
            if ($stmt = mysqli_prepare($connection, $query)) {
                mysqli_stmt_bind_param($stmt, "sssiii", $title, $body, $thumbnail_to_insert, $category_id, $is_featured, $id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);

                if (!mysqli_errno($connection)) {
                    $_SESSION['edit-post-success'] = "Статья успешно обновлена!";
                } else {
                    $_SESSION['edit-post'] = "Ошибка при обновлении статьи.";
                }
            } else {
                $_SESSION['edit-post'] = "Ошибка при подготовке запроса.";
            }
        }
    }

    // Редирект на нужную страницу
    header('location: ' . ROOT_URL . 'admin/');
    die();
}

// Если форма не была отправлена, редирект обратно
header('location: ' . ROOT_URL . 'admin/edit-article.php');
die();
