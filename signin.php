<?php
require 'config/constants.php';

$usernameEmail = $_SESSION['signin-data']['username_email'] ?? null;
$password = $_SESSION['signin-data']['password'] ?? null;

unset($_SESSION['signin-data']);
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
<!--Sign In -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 col-xl-7">

            <div class="sign-in mt-5">
                <h1 class="mb-5">Вход в аккаунт</h1>
                <?php if (isset($_SESSION['signup-success'])): ?>
                    <div class="alert alert-success" role="alert">
                        <?= $_SESSION['signup-success'];
                        unset($_SESSION['signup-success']) ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['signin'])): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $_SESSION['signin']; ?>
                        <?php unset($_SESSION['signin']); ?>
                    </div>
                <?php endif ?>
                <form action="<?= ROOT_URL ?>signin-logic.php" method="post">
                    <div class="mb-3">
                        <label for="loginInput" class="form-label">Логин или электронная почта</label>
                        <input type="text" class="form-control" id="loginInput" aria-describedby="loginInput"
                               name="username_email" value="<?= $usernameEmail ?>">
                    </div>
                    <div class="mb-3">
                        <label for="passwordInput" class="form-label">Пароль</label>
                        <input type="password" class="form-control" id="passwordInput" placeholder="*******"
                               name="password" value="<?= $password ?>">
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg" name="submit">Войти</button>
                </form>
                <p class="mt-3">Нет аккаунта? <a class="text-primary" href="signup.php">Зарегистрироваться</a></p>
            </div>
        </div>
    </div>
</div>
<!-- Sign in End -->

<?php
include 'partials/footer.php';
?>
</body>
</html>
