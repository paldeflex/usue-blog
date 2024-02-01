<?php
require __DIR__ . '/../config/database.php';

$currentPath = $_SERVER['REQUEST_URI'];
$current_page = basename($_SERVER['SCRIPT_NAME']);
$isAdminPath = str_starts_with($_SERVER['REQUEST_URI'], '/admin'); // Проверка, начинается ли путь с '/admin'

// Извлечь текущего пользователя из базы данных
if (isset($_SESSION['user-id'])) {
    $id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT first_name, last_name, profile_pic FROM users WHERE id='$id'";
    $result = mysqli_query($connection, $query);
    $userData = mysqli_fetch_assoc($result);
} elseif ($isAdminPath) {
    // Перенаправление на страницу входа, если пользователь не авторизован и пытается войти в админку
    header('Location: ' . ROOT_URL . 'signin.php');
    exit;
}
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicons/favicon-16x16.png">
    <link rel="manifest" href="/assets/images/favicons/site.webmanifest">
    <link rel="mask-icon" href="/assets/images/favicons/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="icon" type="image/x-icon" href="/assets/images/favicons/favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/bootstrap-icons/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/assets/css/main.css">
    <title>УрГЭУ Блог</title>
</head>
<body>
<!-- Header -->
<header class="header">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="<?= ROOT_URL ?>">Блог УрГЭУ</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                    aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto header-navbar p-0">
                    <li class="nav-item">
                        <a class="nav-link <?= $current_page == 'index.php' && !$isAdminPath ? 'active' : ''; ?>"
                           href="<?= ROOT_URL ?>index.php">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $current_page == 'articles.php' ? 'active' : ''; ?>"
                           href="<?= ROOT_URL ?>articles.php">Статьи</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $current_page == 'about.php' ? 'active' : ''; ?>"
                           href="<?= ROOT_URL ?>about.php">Об Университете</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $current_page == 'contacts.php' ? 'active' : ''; ?>"
                           href="<?= ROOT_URL ?>contacts.php">Контакты</a>
                    </li>
                    <?php if (isset($_SESSION['user-id'])): ?>
                        <li class="nav-item dropdown">
                            <a class="btn dropdown-toggle header-dropdown" href="#" role="button"
                               data-bs-toggle="dropdown"
                               aria-expanded="false">
                                <img class="rounded-circle author-pic"
                                     src="<?= ROOT_URL . 'assets/images/' . $userData['profile_pic'] ?>" alt="">
                                <span class="header-dropdown-title"><?= $userData['first_name'] . " " . $userData['last_name'] ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end header-dropdown-items">
                                <li><a class="dropdown-item <?= $isAdminPath ? 'active' : ''; ?>"
                                       href="<?= ROOT_URL ?>admin">Админ
                                        панель</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item text-danger" href="<?= ROOT_URL ?>logout.php">Выйти</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                               href="<?= ROOT_URL ?>signin.php"><i class="bi bi-person-up me-1"></i>Войти в аккаунт</a>
                        </li>
                    <?php endif ?>
                </ul>
            </div>
        </div>
    </nav>
</header>
<!-- Header End -->
