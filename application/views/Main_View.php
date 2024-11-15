<div class="main-container">
  <label class="center-label">News</label>
  <?php if ($_SESSION['allowCreate']): ?>
      <button id="create-article-btn" onclick="window.location.href='create_article.php'">Создать</button>

  <?php else: ?>

  <?php endif; ?>
  <div id="article-list">
    <?php
    if (isset($data["articles"]) && is_array($data['articles'])) {
        foreach ($data['articles'] as $article) {
            echo '<div class="article-item">';
            echo '<a href="/article_detail?id=' . $article['id'] . '">' . htmlspecialchars($article['title']) . " ". htmlspecialchars($article['id']) . '</a>';
            echo '</div>';
        }
    }
    ?>
  </div>
</div>

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

<script src="application/assets/js/login.js"></script>
<script src="application/assets/js/articlesContainer.js"></script>
