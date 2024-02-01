<?php
require 'config/constants.php';

// Сохранять заполненные данные есть ошибка при регистрации
$firstName = $_SESSION['signup-data']['first_name'] ?? null;
$lastName = $_SESSION['signup-data']['last_name'] ?? null;
$username = $_SESSION['signup-data']['username'] ?? null;
$email = $_SESSION['signup-data']['email'] ?? null;
$password = $_SESSION['signup-data']['password'] ?? null;
$passwordConfirm = $_SESSION['signup-data']['password_confirm'] ?? null;
unset($_SESSION['signup-data'])
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
<!--Sign Up -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 col-xl-7">
            <div class="sign-in my-5">
                <h1 class="mb-5">Регистрация</h1>
                <?php
                if (isset($_SESSION['signup'])): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $_SESSION['signup']; ?>
                        <?php unset($_SESSION['signup']); ?>
                    </div>
                <?php endif ?>
                <form action="<?= ROOT_URL ?>signup-logic.php" enctype="multipart/form-data" method="post">
                    <div class="mb-4">
                        <input type="text" class="form-control" id="firstNameInput" placeholder="Имя" name="first_name"
                               value="<?= $firstName ?>">
                    </div>
                    <div class="mb-4">
                        <input type="text" class="form-control" id="lastNameInput" placeholder="Фамилия"
                               name="last_name" value="<?= $lastName ?>">
                    </div>
                    <div class="mb-4">
                        <input type="text" class="form-control" id="usernameInput" placeholder="Логин" name="username" value="<?= $username ?>">
                    </div>
                    <div class="mb-4">
                        <input type="email" class="form-control" id="emailInput" placeholder="Электронная почта"
                               name="email" value="<?= $email ?>">
                    </div>
                    <div class="mb-4">
                        <input type="password" class="form-control" id="passwordInput" placeholder="Пароль"
                               name="password" value="<?= $password ?>">
                    </div>
                    <div class="mb-4">
                        <input type="password" class="form-control" id="passwordConfirmInput"
                               placeholder="Повторите пароль" name="password_confirm" value="<?= $passwordConfirm ?>">
                    </div>
                    <div class="mb-4">
                        <label for="profilePic" class="form-label fw-semibold">Изображение профиля</label>
                        <input class="form-control form-control" id="profilePic" type="file" name="profile_pic">
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg" name="submit">Зарегистрироваться</button>
                    <p class="mt-3">Уже есть аккаунт? <a class="text-primary" href="signin.php">Войти</a></p>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Sign Up End -->
</body>
</html>
