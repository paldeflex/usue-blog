<?php
include 'partials/header.php';

// Извлечь категории из БД
$query = "SELECT * FROM categories";
$categories = mysqli_query($connection, $query);
setlocale(LC_TIME, 'ru_RU.UTF-8');

function add3dots($string, $repl, $limit) {
    if (mb_strlen($string) > $limit) {
        return mb_substr($string, 0, $limit, 'UTF-8') . $repl;
    } else {
        return $string;
    }
}

setlocale(LC_ALL, 'ru_RU.UTF-8', 'rus_RUS.UTF-8', 'Russian_Russia.UTF-8');

// Извлечь статьи из таблицы posts
$posts_query = "SELECT * FROM posts ORDER BY date_time DESC LIMIT 9";
$posts = mysqli_query($connection, $posts_query);
?>

<!-- Search Bar -->
<div class="container">
    <div class="search-bar my-5">
        <div class="row">
            <form action="<?= ROOT_URL ?>search.php" method="get">
                <div class="col-md-12 col-lg-7 mx-auto">
                    <div class="input-group">
                        <input type="search" class="form-control form-control-lg" placeholder="Что хотите найти?"
                               aria-label="Поиск" aria-describedby="search" name="search">
                        <button class="btn btn-outline-secondary" type="submit" id="search" name="submit">
                            <i class="bi bi-search px-2"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Search Bar End -->

<!-- Posts -->
<div class="container">
    <?php if (mysqli_num_rows($posts) > 0): ?>
        <div class="row row-cols-1 row-cols-md-3 g-4 mt-2">
            <?php while ($post = mysqli_fetch_assoc($posts)): ?>
                <div class="co-sm-12 col-md-6 col-lg-4 posts">
                    <div class="card h-100 shadow-sm">
                        <a href="<?= ROOT_URL ?>single.php?id=<?= $post['id'] ?>">
                            <img src="<?= ROOT_URL ?>assets/images/<?= $post['thumbnail'] ?>" class="card-img-top"
                                 style="height: 250px" alt="...">
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
                                <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $category['id'] ?>"
                                   class="btn btn-secondary btn-sm mb-3"><?= $category['title'] ?></a>
                                <h5 class="card-title"><a href="<?= ROOT_URL ?>single.php?id=<?= $post['id'] ?>"
                                                          class="posts-link link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"><?= $post['title'] ?></a>
                                </h5>
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
                                    <img src="assets/images/<?= $author['profile_pic'] ?>"
                                         class="author-pic rounded shadow-sm"
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

<!-- Categories -->
<div class="categories container my-5 border-top pt-5">
    <?php while ($category = mysqli_fetch_assoc($categories)): ?>
        <a href="category-posts.php?id=<?= $category['id'] ?>"
           class="btn btn-secondary categories-item"><?= $category['title'] ?></a>
    <?php endwhile; ?>
</div>
<!-- Categories End -->


<?php
include 'partials/footer.php';
?>
