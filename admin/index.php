<?php
include '../partials/header.php';

// Извлечь все статьи
$current_user_id = $_SESSION['user-id'];
$query = "SELECT id, title, category_id FROM posts WHERE author_id=$current_user_id ORDER BY id DESC";
$articles = mysqli_query($connection, $query);
?>

    <!-- Admin -->
    <div class="container">
        <div class="admin my-5">
            <div class="row">
                <?php include 'partials/sidebar.php'; ?>
                <div class="col-md-12 col-lg-9">
                    <h1 class="mb-4">Управление статьями</h1>
                    <div class="mt-4">
                        <?php if (isset($_SESSION['add-post-success'])): ?>
                            <div class="alert alert-success" role="alert">
                                <?= $_SESSION['add-post-success'];
                                unset($_SESSION['add-post-success']) ?>
                            </div>
                        <?php elseif (isset($_SESSION['edit-post'])):; ?>
                            <div class="alert alert-danger" role="alert">
                                <?= $_SESSION['edit-post']; ?>
                                <?php unset($_SESSION['edit-post']); ?>
                            </div>
                        <?php elseif (isset($_SESSION['edit-post-success'])): ?>
                            <div class="alert alert-success" role="alert">
                                <?= $_SESSION['edit-post-success']; ?>
                                <?php unset($_SESSION['edit-post-success']); ?>
                            </div>
                        <?php elseif (isset($_SESSION['delete-post'])): ?>
                            <div class="alert alert-success" role="alert">
                                <?= $_SESSION['delete-post']; ?>
                                <?php unset($_SESSION['delete-post']); ?>
                            </div>
                        <?php elseif (isset($_SESSION['delete-post-success'])): ?>
                            <div class="alert alert-success" role="alert">
                                <?= $_SESSION['delete-post-success']; ?>
                                <?php unset($_SESSION['delete-post-success']); ?>
                            </div>
                        <?php endif ?>
                    </div>

                    <?php if (mysqli_num_rows($articles) > 0): ?>
                        <div class="table-responsive-sm">
                            <table class="table table-hover text-center">
                                <thead class="table-light">
                                <tr>
                                    <th scope="col" class="py-3 text-start">Заголовок</th>
                                    <th scope="col" class="py-3 text-start">Категория</th>
                                    <th scope="col" class="py-3">Редактирование</th>
                                    <th scope="col" class="py-3">Удаление</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php while ($article = mysqli_fetch_assoc($articles)): ?>
                                    <?php
                                    $category_id = $article['category_id'];
                                    $category_query = "SELECT title FROM categories WHERE id = '$category_id'";
                                    $category_result = mysqli_query($connection, $category_query);
                                    $category = mysqli_fetch_assoc($category_result);
                                    ?>
                                    <tr>
                                        <td class="text-start"><?= $article['title'] ?></td>
                                        <td class="text-start"><?= $category['title'] ?></td>
                                        <td>
                                            <a href="<?= ROOT_URL ?>admin/edit-article.php?id=<?= $article['id'] ?>"
                                               class="btn btn-primary"><i class="bi bi-pen"></i></a>
                                        </td>
                                        <td>
                                            <a href="<?= ROOT_URL ?>admin/delete-article.php?id=<?= $article['id'] ?>"
                                               class="btn btn-danger"><i class="bi bi-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-primary" role="alert">
                            Статьи не найдены
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