<!-- /application/views/article_detail_view.php -->

<div class="main-container">
    <h1 class="center-label"><?php echo htmlspecialchars($data['article']['title']); ?></h1>

    <!-- Карусель изображений -->
    <div class="carousel">
        <div class="carousel-images">
            <?php foreach ($data['images'] as $index => $image): ?>
                <div class="carousel-item" data-index="<?php echo $index; ?>">
                    <img src="<?php echo htmlspecialchars($image); ?>" alt="Article Image">
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Миниатюры изображений -->
    <div class="thumbnails-wrapper">
        <div class="thumbnails">
            <?php foreach ($data['images'] as $index => $image): ?>
                <div class="thumbnail" data-index="<?php echo $index; ?>">
                    <img src="<?php echo htmlspecialchars($image); ?>" alt="Thumbnail Image">
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Контент статьи -->
    <?php if ($data['article']): ?>
        <p class="article-content"><?php echo htmlspecialchars($data['article']['content']); ?></p>
    <?php else: ?>
        <p>Статья не найдена.</p>
    <?php endif; ?>

    <!-- Секция комментариев -->
    <div class="comments-section">
        <h3 class="center-label">Комментарии</h3>

        <?php if ($data['permissions']['allowWriteComm']): ?>
            <input type="hidden" id="article_id" value="<?php echo $articleId; ?>">
            <textarea class="form-control" id="commentContent" rows="2" placeholder="Напишите комментарий..."></textarea>
            <a href="#" id="submitComment" class="btn btn-primary mt-2">Отправить</a>
        <?php elseif (!$user_id): ?>
            <p><a href="/login">Войдите</a>, чтобы оставить комментарий.</p>
        <?php else: ?>
            <p>У вас нет прав для добавления комментариев.</p>
        <?php endif; ?>

        <!-- Список комментариев -->
        <div class="comments-list">
            <?php if ($data['comments']->num_rows > 0): ?>
                <?php while ($comment = $data['comments']->fetch_assoc()): ?>
                    <div class="comment">
                        <p><strong><?php echo htmlspecialchars($comment['username']); ?></strong></p>
                        <p><?php echo nl2br(htmlspecialchars($comment['content'])); ?></p>
                        <small style="color: gray;"><?php echo $comment['created_at']; ?></small>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Пока нет комментариев.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="application/assets/js/comments.js"></script>
<script src="application/assets/js/login.js"></script>
<script src="application/assets/js/imageCarousel.js"></script>
