<?php
include '../partials/header.php';
if (!isset($_SESSION['user_is_admin'])) {
    // Пользователь не администратор
    header('Location: ' . ROOT_URL . 'admin');
    exit;
}

// Сохранить заполнение полей при ошибке
$firstName = $_SESSION['add-user-data']['first_name'] ?? null;
$lastName = $_SESSION['add-user-data']['last_name'] ?? null;
$username = $_SESSION['add-user-data']['username'] ?? null;
$email = $_SESSION['add-user-data']['email'] ?? null;
$password = $_SESSION['add-user-data']['password'] ?? null;
$passwordConfirm = $_SESSION['add-user-data']['password_confirm'] ?? null;

unset($_SESSION['add-user-data'])
?>

<!-- Add Article -->
<div class="container">
    <div class="admin mt-5">
        <div class="row">
            <?php include 'partials/sidebar.php'; ?>
            <div class="col-md-12 col-lg-9 mb-5">
                <h1 class="mb-4">Добавить пользователя</h1>
                <?php
                if (isset($_SESSION['add-user'])): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $_SESSION['add-user']; ?>
                        <?php unset($_SESSION['add-user']); ?>
                    </div>
                <?php endif ?>
                <form action="<?= ROOT_URL ?>admin/add-user-logic.php" method="post" enctype="multipart/form-data">
                    <div class="mb-4">
                        <input type="text" class="form-control" id="nameInput" placeholder="Имя" name="first_name" value="<?= $firstName ?>">
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
                        <label for="inputUserRole" class="form-label fw-semibold">Роль пользователя</label>
                        <select class="form-select" aria-label="Категория статьи" id="inputUserRole" name="user_role">
                            <option value="0">Автор</option>
                            <option value="1">Администратор</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="inputFile" class="form-label fw-semibold">Изображение профиля</label>
                        <input class="form-control form-control" id="inputFile" type="file" name="profile_pic">
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg" name="submit">Добавить</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Add Article End -->

<?php
include '../partials/footer.php';
?>

