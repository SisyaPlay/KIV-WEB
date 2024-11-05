<?php
if ($data['hasPermission']):
    ?>
    <div class="main-container">
        <label class="center-label">News</label>
        <button id="create-article-btn" onclick="window.location.href='create_article.php'">Создать</button>
        <div id="article-list"></div>
    </div>
<?php else: ?>
    <div class="main-container">
        <label class="center-label">News</label>
        <div id="article-list"></div>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['registered'])): ?>
    <p class="registeredMessage"><?= $_SESSION['registered'] ?></p>
    <script>
        setTimeout(() => {
            const message = document.querySelector(".registeredMessage");
            if (message) {
                message.classList.add("fadeOut");
            }
        }, 1000);
    </script>
    <?php unset($_SESSION['registered']); endif; ?>

<?php if (isset($_SESSION['massage'])): ?>
    <p class="msg"><?= $_SESSION['massage'] ?></p>
    <script>
        setTimeout(() => {
            const message = document.querySelector(".msg");
            if (message) {
                message.classList.add("fadeOut");
            }
        }, 1000);
    </script>
    <?php unset($_SESSION['massage']); endif; ?>
