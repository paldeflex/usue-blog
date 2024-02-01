<?php
include 'partials/header.php';

function add3dots($string, $repl, $limit) {
    if (mb_strlen($string) > $limit) {
        return mb_substr($string, 0, $limit, 'UTF-8') . $repl;
    } else {
        return $string;
    }
}

// Извлечь статьи если есть ID
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE category_id='$id' ORDER BY date_time DESC";
    $posts = mysqli_query($connection, $query);
} else {
    header('location: ' . ROOT_URL . 'index.php');
    die();
}
?>

<!-- Title -->
<div class="container text-center my-5">

    <?php
    // Извлечь категори из таблицы с категориями используя category_id статьи
    $category_id = $id;
    $category_query = "SELECT * FROM categories WHERE id='$category_id'";
    $category_result = mysqli_query($connection, $category_query);
    $category = mysqli_fetch_assoc($category_result);
    ?>
    <h1><?= $category['title'] ?></h1>
</div>
<!-- Title End -->

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
    <div class="row m-2">
        <div class="alert alert-primary" role="alert">
            Статей для данной категории нет
        </div>
        <?php endif; ?>
    </div>
</div>
<!-- Posts End -->

<?php
include 'partials/footer.php';
?>
