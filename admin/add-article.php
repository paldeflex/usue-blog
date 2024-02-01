<?php
include '../partials/header.php';

// Извлечь категории из БД
$query = "SELECT * FROM categories";
$categories = mysqli_query($connection, $query);

$title = $_SESSION['add-post-data']['title'] ?? null;
$body = $_SESSION['add-post-data']['body'] ?? null;

unset($_SESSION['add-post-data']);
?>

<!-- Add Article -->
<div class="container">
    <div class="mt-5">
        <div class="row">
            <?php include 'partials/sidebar.php'; ?>
            <div class="col-md-12 col-lg-9 mb-5">
                <h1 class="mb-4">Написать статью</h1>
                <?php
                if (isset($_SESSION['add-post'])): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $_SESSION['add-post']; ?>
                        <?php unset($_SESSION['add-post']); ?>
                    </div>
                <?php endif ?>
                <form action="<?= ROOT_URL ?>admin/add-article-logic.php" method="post" enctype="multipart/form-data">
                    <div class="mb-4">
                        <input type="text" class="form-control" id="articleTitleInput" placeholder="Заголовок"
                               name="title" value="<?= $title ?>">
                    </div>
                    <div class="mb-4">
                        <select class="form-select" aria-label="Категория статьи" name="category">
                            <?php while ($category = mysqli_fetch_assoc($categories)): ?>
                                <option value="<?= $category['id'] ?>"><?= $category['title'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-2">
                        <textarea class="form-control" aria-label="Текст статьи" placeholder="Текст статьи"
                                  rows="5" name="body"><?= $body ?></textarea>
                    </div>
                    <?php if (isset($_SESSION['user_is_admin'])): ?>
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="featuresPostCheck" name="is_featured" value="1">
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
                    <button type="submit" class="btn btn-primary btn-lg" name="submit">Добавить статью</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Add Article End -->

<?php
include '../partials/footer.php';
?>
