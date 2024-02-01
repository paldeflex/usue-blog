<?php
include '../partials/header.php';

if (!isset($_SESSION['user_is_admin'])) {
    // Пользователь не администратор
    header('Location: ' . ROOT_URL . 'admin');
    exit;
}

$title = $_SESSION['add-category-data']['title'] ?? null;
$description = $_SESSION['add-category-data']['description'] ?? null;

unset($_SESSION['add-category-data'])
?>

<!-- Add Article -->
<div class="container">
    <div class="admin mt-5">
        <div class="row">
            <?php include 'partials/sidebar.php'; ?>
            <div class="col-md-12 col-lg-9 mb-5">
                <h1 class="mb-4">Добавить категорию</h1>
                <?php
                if (isset($_SESSION['add-category'])): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $_SESSION['add-category']; ?>
                        <?php unset($_SESSION['add-category']); ?>
                    </div>
                <?php endif ?>
                <form action="<?= ROOT_URL ?>admin/add-category-logic.php" method="post" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label for="inputCategoryName" class="form-label fw-semibold">Название категории</label>
                        <input type="text" class="form-control" id="inputCategoryName" name="title"
                               value="<?= $title ?>">
                    </div>
                    <div class="mb-4">
                        <label for="inputCategoryDesc" class="form-label fw-semibold">Описание категории</label>
                        <textarea class="form-control" aria-label="Текст статьи"
                                  rows="5" id="inputCategoryDesc" name="description"><?= $description ?></textarea>
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
