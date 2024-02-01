<?php
ob_start();

include '../partials/header.php';

if (!isset($_SESSION['user_is_admin'])) {
    header('Location: ' . ROOT_URL . 'admin');
    die();
}

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM users WHERE id='$id'";
    $result = mysqli_query($connection, $query);
    $user = mysqli_fetch_assoc($result);

    if (!$user) {
        // Если пользователь с таким id не найден, перенаправляем на управление пользователями
        header('Location: ' . ROOT_URL . 'admin/manage-users.php');
        die();
    }

} else {
    header('Location: ' . ROOT_URL . 'admin/manage-users.php');
    die();
}

ob_end_flush();
?>

    <!-- Edit Article -->
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-12 col-xl-7">
                <a href="manage-users.php" class="btn mt-4 d-flex px-0 py-2"><i class="bi bi-arrow-left me-2"
                                                                                style="padding-top: 1px"></i>Вернуться
                    назад</a>
                <div class="single-post mt-3">
                    <h1 class="mt-2 mb-5 main-post-title">Редактировать пользователя</h1>
                </div>

                <form action="<?= ROOT_URL ?>admin/edit-user-logic.php" enctype="multipart/form-data" method="post">
                    <input type="hidden" value="<?= $user['id'] ?>" name="id">


                    <div class="mb-4">
                        <label for="inputUserFirstName" class="form-label fw-semibold">Имя пользователя</label>
                        <input type="text" class="form-control" id="inputUserFirstName" placeholder="Имя"
                               value="<?= $user['first_name'] ?>"
                               name="first_name">
                    </div>
                    <div class="mb-4">
                        <label for="inputUserLastName" class="form-label fw-semibold">Фамилия пользователя</label>
                        <input type="text" class="form-control" id="inputUserLastName" placeholder="Фамилия"
                               value="<?= $user['last_name'] ?>" name="last_name">
                    </div>
                    <div class="mb-4">
                        <label for="inputUserRole" class="form-label fw-semibold">Роль пользователя</label>
                        <select class="form-select" aria-label="Роль пользователя" id="inputUserRole" name="user_role">
                            <option value="0" <?= $user['is_admin'] == 0 ? 'selected' : '' ?>>Автор</option>
                            <option value="1" <?= $user['is_admin'] == 1 ? 'selected' : '' ?>>Администратор</option>
                        </select>

                    </div>
                    <button type="submit" class="btn btn-primary btn-lg" name="submit">Редактировать</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Article End -->

<?php
include '../partials/footer.php';
?>