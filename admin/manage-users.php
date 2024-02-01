<?php
include '../partials/header.php';

if (!isset($_SESSION['user_is_admin'])) {
    // Пользователь не администратор - перенаправляем
    header('Location: ' . ROOT_URL . 'admin');
    exit;
}

// Извлечь пользователей из базы данных, но не текущего
$currentAdminId = $_SESSION['user-id'];
$query = "SELECT * FROM users WHERE NOT id='$currentAdminId'";
$users = mysqli_query($connection, $query);
?>

<!-- Admin -->
<div class="container">
    <div class="mt-4">
        <?php if (isset($_SESSION['add-user-success'])): ?>
            <div class="alert alert-success" role="alert">
                <?= $_SESSION['add-user-success'];
                unset($_SESSION['add-user-success']) ?>
            </div>
        <?php elseif (isset($_SESSION['edit-user'])):; ?>
            <div class="alert alert-danger" role="alert">
                <?= $_SESSION['edit-user']; ?>
                <?php unset($_SESSION['edit-user']); ?>
            </div>
        <?php elseif (isset($_SESSION['edit-user-success'])): ?>
            <div class="alert alert-success" role="alert">
                <?= $_SESSION['edit-user-success']; ?>
                <?php unset($_SESSION['edit-user-success']); ?>
            </div>
        <?php elseif (isset($_SESSION['delete-user'])): ?>
            <div class="alert alert-success" role="alert">
                <?= $_SESSION['delete-user']; ?>
                <?php unset($_SESSION['delete-user']); ?>
            </div>
        <?php elseif (isset($_SESSION['delete-user-success'])): ?>
            <div class="alert alert-success" role="alert">
                <?= $_SESSION['delete-user-success']; ?>
                <?php unset($_SESSION['delete-user-success']); ?>
            </div>
        <?php endif ?>
    </div>
    <div class="my-5">
        <div class="row">
            <?php include 'partials/sidebar.php'; ?>
            <div class="col-md-12 col-lg-9">
                <h1 class="mb-4">Управление
                    пользователями</h1>
                <?php if (mysqli_num_rows($users) > 0): ?>
                    <div class="table-responsive-sm">
                        <table class="table table-hover text-center">
                            <thead class="table-light">
                            <tr>
                                <th scope="col" class="py-3 text-start">Имя</th>
                                <th scope="col" class="py-3 text-start">Фамилия</th>
                                <th scope="col" class="py-3 text-start">Логин</th>
                                <th scope="col" class="py-3 text-start">Эл. почта</th>
                                <th scope="col" class="py-3 text-start">Роль</th>
                                <th scope="col" class="py-3">Редактирование</th>
                                <th scope="col" class="py-3">Удаление</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php while ($user = mysqli_fetch_assoc($users)): ?>
                                <tr>
                                    <td class="text-start"><?= $user['first_name'] ?></td>
                                    <td class="text-start"><?= $user['last_name'] ?></td>
                                    <td class="text-start"><?= $user['username'] ?></td>
                                    <td class="text-start"><?= $user['email'] ?></td>
                                    <td class="text-start"><?= $user['is_admin'] ? "Администратор" : "Автор" ?></td>
                                    <td>
                                        <a href="<?= ROOT_URL ?>admin/edit-user.php?id=<?= $user['id'] ?>"
                                           class="btn btn-primary"><i class="bi bi-pen"></i></a>
                                    </td>
                                    <td>
                                        <a href="<?= ROOT_URL ?>admin/delete-user.php?id=<?= $user['id'] ?>"
                                           class="btn btn-danger"><i class="bi bi-trash"></i></a>
                                        <!--                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"-->
                                        <!--                                            data-bs-target=".deleteModal"><i class="bi bi-trash"></i></button>-->
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-primary" role="alert">
                        Пользователи не найдены
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<!-- Admin End -->

<?php
include '../partials/footer.php';
?>
