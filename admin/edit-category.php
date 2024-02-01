<?php
ob_start();

include '../partials/header.php';

if (!isset($_SESSION['user_is_admin'])) {
    // Пользователь не администратор
    header('Location: ' . ROOT_URL . 'admin');
    exit;
}

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM categories WHERE id='$id'";
    $result = mysqli_query($connection, $query);
    $category = mysqli_fetch_assoc($result);

    if (!$category) {
        // Если категория с таким id не найдена, перенаправляем на управление категориями
        header('Location: ' . ROOT_URL . 'admin/manage-categories.php');
        die();
    }

} else {
    header('Location: ' . ROOT_URL . 'admin/manage-categories.php');
    die();
}

ob_end_flush();
?>

    <!-- Edit Article -->
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-12 col-xl-7">
                <a href="manage-categories.php" class="btn mt-4 d-flex px-0 py-2"><i class="bi bi-arrow-left me-2"
                                                                                     style="padding-top: 1px"></i>Вернуться
                    назад</a>
                <div class="single-post mt-3">
                    <h1 class="mt-2 mb-5 main-post-title">Редактировать категорию</h1>
                </div>
                <form action="<?= ROOT_URL ?>admin/edit-category-logic.php" enctype="multipart/form-data" method="post">
                    <input type="hidden" value="<?= $category['id'] ?>" name="id">
                    <div class="mb-4">
                        <input type="text" class="form-control" id="nameInput" placeholder="Имя" value="<?= $category['title'] ?>" name="title">
                    </div>
                    <div class="mb-4">
                        <label for="inputCategoryDesc" class="form-label fw-semibold">Описание категории</label>
                        <textarea class="form-control" aria-label="Текст статьи"
                                  rows="5" id="inputCategoryDesc" name="description"><?= $category['description'] ?></textarea>
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