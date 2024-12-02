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
        <p><?php echo htmlspecialchars($data['translations']['noarticle']); ?></p>
    <?php endif; ?>

    <!-- Секция комментариев -->
    <div class="comments-section">
        <h3 class="center-label"><?php echo htmlspecialchars($data['translations']['comment']); ?></h3>

        <?php if ($data['permissions']['allowWriteComm']): ?>
            <input type="hidden" id="article_id" value="<?php echo $data['article_id']; ?>">
            <textarea class="form-control" id="commentContent" rows="2" placeholder="<?php echo htmlspecialchars($data['translations']['putcomment']); ?>"></textarea>
            <a href="#" id="submitComment" class="btn btn-primary mt-2"><?php echo htmlspecialchars($data['translations']['putcomment']); ?></a>
        <?php elseif (!isset($_SESSION['user_id'])): ?>
            <p><a href="/login"><?php echo htmlspecialchars($data['translations']['login']); ?></a><?php echo htmlspecialchars($data['translations']['loginforcomment']); ?></p>
        <?php else: ?>
            <p><?php echo htmlspecialchars($data['translations']['notallowcomment']); ?></p>
        <?php endif; ?>

        <!-- Список комментариев -->
        <div class="comments-list">
            <?php
            function renderComments($comments, $translation, $parentId = null, $level = 0, $allowWriteComm = false) {
                foreach ($comments as $comment) {
                    // Отображаем только комментарии с текущим parent_id
                    if ($comment['parent_id'] == $parentId) {
                        echo "<div class='comment' style='margin-left: " . ($level * 20) . "px;'>";
                        echo "<p><strong>" . htmlspecialchars($comment['username']) . "</strong></p>";
                        echo "<p>" . nl2br(htmlspecialchars($comment['content'])) . "</p>";
                        echo "<small style='color: gray;'>" . $comment['created_at'] . "</small>";

                        if ($allowWriteComm) {
                            echo "<button type='button' class='btn btn-link reply-button' onclick='showReplyBox(this)'>➡️ " . htmlspecialchars($translation['reply']) . "</button>";
                        }

                        echo "<div class='reply-arrow' style='display:none;'>➤</div>";
                        echo "<div style='display:none;' class='reply-container'>";
                        echo "<textarea class='form-control reply-textarea' rows='1' placeholder='" . htmlspecialchars($translation['replycomment']) . "' style='resize: none;'></textarea>";
                        echo "<button type='button' class='btn btn-link submit-reply' style='display:none;' onclick='submitReply(this, " . $comment['id'] . ")'>" . htmlspecialchars($translation['send']) . "</button>";
                        echo "</div>";

                        echo "</div>";

                        // Рекурсивно отображаем вложенные комментарии
                        renderComments($comments, $translation, $comment['id'], $level + 1, $allowWriteComm);
                    }
                }
            }


            if ($data['comments']->num_rows > 0) {
                // Преобразуем результат запроса в массив
                $commentsArray = $data['comments']->fetch_all(MYSQLI_ASSOC);

                // Вызываем функцию рендеринга
                renderComments($commentsArray, $data['translations'], null, 0, $data['permissions']['allowWriteComm']);
            } else {
                echo "<p>" . htmlspecialchars($data['translations']['nocomments']) . "</p>";
            }
            ?>
        </div>
    </div>
</div>

<script src="application/assets/js/comments.js"></script>
<script src="application/assets/js/login.js"></script>
<script src="application/assets/js/imageCarousel.js"></script>
