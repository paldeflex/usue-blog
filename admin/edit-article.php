<?php
include '../partials/header.php';

// Извлечь категории из БД
$query = "SELECT * FROM categories";
$categories = mysqli_query($connection, $query);
$is_admin = isset($_SESSION['user_is_admin']);

// Извлечь данные из БД если ID пользователя найдено
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE id='$id'";
    $result = mysqli_query($connection, $query);
    $post = mysqli_fetch_assoc($result);


    if (!$post) {
        // Если пользователь с таким id не найден, перенаправляем на страницу с статьями
        header('Location: ' . ROOT_URL . 'admin/');
        die();
    }

} else {
    header('Location: ' . ROOT_URL . 'admin/');
    die();
}
?>

<!-- Edit Article -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 col-xl-7">
            <a href="index.php" class="btn mt-4 d-flex px-0 py-2"><i class="bi bi-arrow-left me-2"
                                                                     style="padding-top: 1px"></i>Вернуться
                назад</a>
            <div class="single-post mt-3">
                <h1 class="mt-2 mb-5 main-post-title">Редактировать статью</h1>
                <form action="<?= ROOT_URL ?>admin/edit-article-logic.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" value="<?= $post['id'] ?>" name="id">
                    <input type="hidden" value="<?= $post['thumbnail'] ?>" name="previous_thumbnail_name">
                    <div class="mb-4">
                        <input type="text" class="form-control" id="articleTitleInput" placeholder="Заголовок"
                               value="<?= $post['title'] ?>" name="title">
                    </div>
                    <div class="mb-4">
                        <select class="form-select" aria-label="Категория статьи" name="category">
                            <?php while ($category = mysqli_fetch_assoc($categories)): ?>
                                <option value="<?= $category['id'] ?>" <?= $category['id'] == $post['category_id'] ? 'selected' : '' ?>><?= $category['title'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="mb-2">
                        <textarea class="form-control" aria-label="Текст статьи" placeholder="Текст статьи"
                                  rows="5" name="body"><?= $post['body'] ?></textarea>
                    </div>
                    <?php if($is_admin): ?>
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="featuresPostCheck" value="1" name="is_featured" <?= $post['is_featured'] == 1 ? 'checked' : '' ?>>
                        <label class="form-check-label" for="featuresPostCheck">
                            Главный пост?
                        </label>
                        <i class="bi bi-question-circle ml-2 pe-auto" data-bs-toggle="tooltip"
                           data-bs-title="Добавляет большую карточку статьи на главную страницу блога"></i>
                    </div>
                    <?php endif; ?>

                    <div class="mb-4">
                        <label for="inputFile" class="form-label fw-semibold">Изображение статьи</label>
                        <input class="form-control form-control" id="inputFile" type="file" name="thumbnail">
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg" name="submit">Редактировать</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Edit Article End -->

<?php
include '../partials/footer.php';
?>
