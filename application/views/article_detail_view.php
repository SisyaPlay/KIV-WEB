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
        <p class="article-content"><?php echo $data['article']['content']; ?></p>
    <?php else: ?>
        <p>Статья не найдена.</p>
    <?php endif; ?>

    <!-- Секция комментариев -->
    <div class="comments-section">
        <h3 class="center-label">Комментарии</h3>

        <?php if ($data['permissions']['allowWriteComm']): ?>
            <input type="hidden" id="article_id" value="<?php echo $data['article_id']; ?>">
            <textarea class="form-control" id="commentContent" rows="2" placeholder="Напишите комментарий..."></textarea>
            <a href="#" id="submitComment" class="btn btn-primary mt-2">Отправить</a>
        <?php elseif (!isset($_SESSION['user_id'])): ?>
            <p><a href="/login">Войдите</a>, чтобы оставить комментарий.</p>
        <?php else: ?>
            <p>У вас нет прав для добавления комментариев.</p>
        <?php endif; ?>

        <!-- Список комментариев -->
        <div class="comments-list">
            <?php
            function renderComments($comments, $parentId = null, $level = 0, $allowWriteComm = false)
            {
                foreach ($comments as $comment) {
                    // Отображаем только комментарии с текущим parent_id
                    if ($comment['parent_id'] == $parentId) {
                        echo "<div class='comment' style='margin-left: " . ($level * 20) . "px;'>";
                        echo "<p><strong>" . htmlspecialchars($comment['username']) . "</strong></p>";
                        echo "<p>" . nl2br(htmlspecialchars($comment['content'])) . "</p>";
                        echo "<small style='color: gray;'>" . $comment['created_at'] . "</small>";

                        if ($allowWriteComm) {
                            echo "<button type='button' class='btn btn-link reply-button' onclick='showReplyBox(this)'>➡️ Ответить</button>";
                        }

                        echo "<div class='reply-arrow' style='display:none;'>➤</div>";
                        echo "<div style='display:none;' class='reply-container'>";
                        echo "<textarea class='form-control reply-textarea' rows='1' placeholder='Ответить на комментарий...' style='resize: none;'></textarea>";
                        echo "<button type='button' class='btn btn-link submit-reply' style='display:none;' onclick='submitReply(this, " . $comment['id'] . ")'>Отправить</button>";
                        echo "</div>";

                        echo "</div>";

                        // Рекурсивно отображаем вложенные комментарии
                        renderComments($comments, $comment['id'], $level + 1, $allowWriteComm);
                    }
                }
            }

            if ($data['comments']->num_rows > 0) {
                // Преобразуем результат запроса в массив
                $commentsArray = $data['comments']->fetch_all(MYSQLI_ASSOC);

                // Вызываем функцию рендеринга
                renderComments($commentsArray, null, 0, $data['permissions']['allowWriteComm']);
            } else {
                echo "<p>Пока нет комментариев.</p>";
            }
            ?>
        </div>

    </div>
</div>

<script src="application/assets/js/comments.js"></script>
<script src="application/assets/js/login.js"></script>
<script src="application/assets/js/imageCarousel.js"></script>
