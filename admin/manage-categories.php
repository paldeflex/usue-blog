<?php
include '../partials/header.php';

if (!isset($_SESSION['user_is_admin'])) {
    // Пользователь не администратор
    header('Location: ' . ROOT_URL . 'admin');
    exit;
}

// Извлечь все категории
$query = "SELECT * FROM categories";
$categories = mysqli_query($connection, $query);
?>

    <!-- Admin -->
    <div class="container">
        <?php if (isset($_SESSION['add-category-success'])): ?>
            <div class="alert alert-success mt-4" role="alert">
                <?= $_SESSION['add-category-success'];
                unset($_SESSION['add-category-success']) ?>
            </div>
        <?php elseif (isset($_SESSION['delete-category-success'])):; ?>
            <div class="alert alert-success mt-4" role="alert">
                <?= $_SESSION['delete-category-success'];
                unset($_SESSION['delete-category-success']) ?>
            </div>
        <?php elseif (isset($_SESSION['edit-category-success'])): ?>
            <div class="alert alert-success mt-4" role="alert">
                <?= $_SESSION['edit-category-success']; ?>
                <?php unset($_SESSION['edit-category-success']); ?>
            </div>
        <?php elseif (isset($_SESSION['edit-category'])): ?>
            <div class="alert alert-danger mt-4" role="alert">
                <?= $_SESSION['edit-category']; ?>
                <?php unset($_SESSION['edit-category']); ?>
            </div>
        <?php elseif (isset($_SESSION['delete-category'])): ?>
            <div class="alert alert-danger mt-4" role="alert">
                <?= $_SESSION['delete-category']; ?>
                <?php unset($_SESSION['delete-category']); ?>
            </div>
        <?php endif ?>
        <div class="my-5">
            <div class="row">
                <?php include 'partials/sidebar.php'; ?>
                <div class="col-md-12 col-lg-9">
                    <h1 class="mb-4">Управление
                        категориями</h1>
                    <?php if (mysqli_num_rows($categories) > 0): ?>
                        <div class="table-responsive-sm">
                            <table class="table table-hover text-center">
                                <thead class="table-light">
                                <tr>
                                    <th scope="col" class="py-3 text-start">Название</th>
                                    <th scope="col" class="py-3 text-start">Описание</th>
                                    <th scope="col" class="py-3">Редактирование</th>
                                    <th scope="col" class="py-3">Удаление</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php while ($category = mysqli_fetch_assoc($categories)): ?>
                                    <tr>
                                        <td class="text-start"><?= $category['title'] ?></td>
                                        <td class="text-start"><?= $category['description'] ?></td>
                                        <td>
                                            <a href="<?= ROOT_URL ?>admin/edit-category.php?id=<?= $category['id'] ?>"
                                               class="btn btn-primary"><i class="bi bi-pen"></i></a>
                                        </td>
                                        <td>
                                            <a href="<?= ROOT_URL ?>admin/delete-category.php?id=<?= $category['id'] ?>"
                                               class="btn btn-danger"><i class="bi bi-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-primary" role="alert">
                            Категории не найдены
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