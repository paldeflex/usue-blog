<?php
require '../config/database.php';

const PASSWORD_LENGHT = 6;
const ALLOWED_IMAGE_SIZE = 1048576;

if (isset($_POST['submit'])) {
    $author_id = $_SESSION['user-id'];
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $thumbnail = $_FILES['thumbnail'];

    // Установить is_featured на 0 если снят флажок
    $is_featured = $is_featured == 1 ?: 0;

    // Валидация данных формы
    if (!$title) {
        $_SESSION['add-post'] = "Введите заголовок статьи.";
    } elseif (!$body) {
        $_SESSION['add-post'] = "Введите текст статьи";
    } elseif (!$thumbnail['name']) {
        $_SESSION['add-post'] = "Выберите фотографию для статьи";
    } else {
        // Работа с изображением пользователя
        // Переименовать изображение пользователя
        $time = time(); // Сделать каждое изображение уникальных используя текущее время
        $thumbnailName = $time . $thumbnail['name'];
        $thumbnailTmpName = $thumbnail['tmp_name'];
        $thumbnailDestinationPath = '../assets/images/' . $thumbnailName;

        // Убедиться что файл это изображение
        $allowedFiles = ['png', 'jpg', 'jpeg'];
        $allowedFilesFormats = implode(', ', $allowedFiles);
        $extension = explode('.', $thumbnailName);
        $extension = end($extension);
        if (in_array($extension, $allowedFiles)) {
            // Убедиться что размер файла не слишком большой
            if ($thumbnail['size'] < ALLOWED_IMAGE_SIZE) {
                // Загрузка изображения пользователя
                move_uploaded_file($thumbnailTmpName, $thumbnailDestinationPath);
            } else {
                $_SESSION['add-post'] = 'Размер файла слишком большой. Файл должен быть меньше чем ' . (ALLOWED_IMAGE_SIZE / 1024 / 1024) . 'мб.';
            }
        } else {
            $_SESSION['add-post'] = "Файл должен быть следующих форматов: " . $allowedFilesFormats;
        }
    }

    // Редирект к странице регистрации, если есть какие-то проблемы
    if ($_SESSION['add-post']) {
        $_SESSION['add-post-data'] = $_POST;
        header('location: ' . ROOT_URL . 'admin/add-article.php');
        die();
    } else {
        // Установить значение is_featured всех статей на 0, а для отмеченного чекбоксом статьи на 1
        if ($is_featured == 1) {
            $zero_all_is_featured_query = "UPDATE posts SET is_featured=0";
            mysqli_query($connection, $zero_all_is_featured_query);
        }

        // Вставка нового пользователя в таблицу пользователей
        $insertPostQuery = "INSERT INTO posts (title, body, thumbnail, category_id, author_id, is_featured )
                    VALUES('$title', '$body', '$thumbnailName', '$category_id', '$author_id', '$is_featured')";
        $insertPostResult = mysqli_query($connection, $insertPostQuery);

        if (!mysqli_errno($connection)) {
            // Редирект к странице со статьями и сообщении об успехе
            $_SESSION['add-post-success'] = "Статья успешно добавлна!";
            header('location: ' . ROOT_URL . 'admin/');
            die();
        }
    }
} else {
    // Если кнопка не была нажата, возвращаемся обратно на страницу добавления стетй
    header('location: ' . ROOT_URL . 'admin/add-article.php');
    die();
}