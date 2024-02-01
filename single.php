<?php
include 'partials/header.php';

// Извлечь пост из БД если есть ID
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE id='$id'";
    $result = mysqli_query($connection, $query);
    $post = mysqli_fetch_assoc($result);
} else {
    header('location: ' . ROOT_URL . 'index.php');
    die();
}
?>


<!--Single Article -->
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-12 col-xl-7">
            <div class="single-post mt-3">
                <h1 class="mt-2 main-post-title"><?= $post['title'] ?></h1>
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
                <div class="mt-4">
                    <img src="assets/images//<?= $post['thumbnail'] ?>" class="card-img-top rounded shadow-sm" alt="...">
                </div>
                <article class="article mt-4"></article>
                <p class="mt-2 paragraph"><?= $post['body'] ?></p>

            </div>
        </div>
    </div>
</div>
<!-- Single Article End -->


<?php
include 'partials/footer.php';
?>
