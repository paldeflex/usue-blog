<div class="col-md-12 col-lg-3">
    <div class="list-group mt-2 mb-5">
        <?php
        $current_page = basename($_SERVER['SCRIPT_NAME']);
        ?>

        <a href="add-article.php"
           class="list-group-item list-group-item-action d-flex align-items-center <?= $current_page == 'add-article.php' ? 'active' : ''; ?>">
            <i class="fs-5 bi bi-pencil-square me-2"></i>Написать статью</a>

        <a href="index.php"
           class="list-group-item list-group-item-action d-flex align-items-center <?= $current_page == 'index.php' ? 'active' : ''; ?>"
           aria-current="true"><i class="fs-5 bi bi-book me-2"></i>Управление статьями</a>

        <?php if (isset($_SESSION['user_is_admin'])): ?>
            <a href="add-user.php"
               class="list-group-item list-group-item-action d-flex align-items-center <?= $current_page == 'add-user.php' ? 'active' : ''; ?>">
                <i class="fs-5 bi bi-person-add me-2"></i>Добавить пользователя</a>

            <a href="manage-users.php"
               class="list-group-item list-group-item-action d-flex align-items-center <?= $current_page == 'manage-users.php' ? 'active' : ''; ?>">
                <i class="fs-5 bi bi-person-gear me-2"></i>Управление пользователями</a>

            <a href="add-category.php"
               class="list-group-item list-group-item-action d-flex align-items-center <?= $current_page == 'add-category.php' ? 'active' : ''; ?>">
                <i class="fs-5 bi bi-node-plus me-2"></i>Добавить категорию</a>

            <a href="manage-categories.php"
               class="list-group-item list-group-item-action d-flex align-items-center <?= $current_page == 'manage-categories.php' ? 'active' : ''; ?>">
                <i class="fs-5 bi bi-diagram-3 me-2"></i>Управление категориями</a>
        <?php endif; ?>
    </div>
</div>
