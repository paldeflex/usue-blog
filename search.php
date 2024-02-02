<?php
include 'partials/header.php';

function add3dots($string, $repl, $limit) {
    if (mb_strlen($string) > $limit) {
        return mb_substr($string, 0, $limit, 'UTF-8') . $repl;
    } else {
        return $string;
    }
}

setlocale(LC_ALL, 'ru_RU.UTF-8', 'rus_RUS.UTF-8', 'Russian_Russia.UTF-8');

if (isset($_GET['search']) && !empty($_GET['search'])) {
    // Получение и фильтрация поискового запроса
    $search = filter_var($_GET['search'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Экранирование специальных символов для SQL LIKE
    $search = str_replace(['%', '_'], ['\%', '\_'], $search);
    $search = "%{$search}%";

    // Подготовленный запрос
    $query = "SELECT * FROM posts WHERE title LIKE ? OR body LIKE ? ORDER BY date_time DESC";

    if ($stmt = mysqli_prepare($connection, $query)) {
        mysqli_stmt_bind_param($stmt, "ss", $search, $search);

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $posts = $result;
    } else {
        // Обработка ошибки подготовки запроса
        echo "Ошибка при подготовке запроса: " . mysqli_error($connection);
    }
} else {
    header('location: ' . ROOT_URL . 'articles.php');
    die();
}
?>

<!-- Posts -->
<div class="container">
    <?php if (mysqli_num_rows($posts) > 0): ?>
        <div class="row row-cols-1 row-cols-md-3 g-4 mt-2">
            <?php while ($post = mysqli_fetch_assoc($posts)): ?>
                <div class="co-sm-12 col-md-6 col-lg-4 posts">
                    <div class="card h-100 shadow-sm">
                        <a href="<?= ROOT_URL ?>single.php?id=<?= $post['id'] ?>">
                            <img src="<?= ROOT_URL ?>assets/images/<?= $post['thumbnail'] ?>" class="card-img-top" style="height: 250px" alt="...">
                        </a>
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div class="card-content">
                                <?php
                                // Извлечь категори из таблицы с категориями используя category_id статьи
                                $category_id = $post['category_id'];
                                $category_query = "SELECT * FROM categories WHERE id='$category_id'";
                                $category_result = mysqli_query($connection, $category_query);
                                $category = mysqli_fetch_assoc($category_result);
                                ?>
                                <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $category['id'] ?>" class="btn btn-secondary btn-sm mb-3"><?= $category['title'] ?></a>
                                <h5 class="card-title"><a href="<?= ROOT_URL ?>single.php?id=<?= $post['id'] ?>"
                                                          class="posts-link link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"><?= $post['title'] ?></a></h5>
                                <p class="card-text"><?= add3dots($post['body'], "...", 150) ?></p>
                            </div>
                            <div class="author mt-4">
                                <?php
                                //Извлечь автора из таблицы users исользуя author_id
                                $author_id = $post['author_id'];
                                $author_query = "SELECT * FROM users WHERE id='$author_id'";
                                $author_result = mysqli_query($connection, $author_query);
                                $author = mysqli_fetch_assoc($author_result);
                                ?>
                                <div class="d-flex align-items-center">
                                    <img src="assets/images/<?= $author['profile_pic'] ?>" class="author-pic rounded shadow-sm"
                                         alt="Author Pic">
                                    <div class="px-3">
                                        <h6 class="card-title mb-0"><?= "{$author['first_name']} {$author['last_name']}" ?></h6>
                                        <p class="card-text"><small
                                                class="text-muted"><?= strftime("%d %B, %Y - %H:%M", strtotime($post['date_time'])) ?></small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile ?>
        </div>
    <?php else: ?>
    <div class="row m-5">
        <div class="alert alert-primary" role="alert">
            Статьи не найдены
        </div>
        <?php endif; ?>
    </div>
</div>
<!-- Posts End -->

<?php
include 'partials/footer.php';
?>
