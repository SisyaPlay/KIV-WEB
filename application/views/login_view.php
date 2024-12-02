<form id="loginForm" action="/login" method="post">
    <input type="hidden" name="redirect_to" value="login_page">
    <label for="username"><?php echo htmlspecialchars($data['translations']['username']); ?>:</label>
    <div class="input-wrapper">
        <input type="text" name="username" id="username" placeholder="<?php echo htmlspecialchars($data['translations']['typename']); ?>">
        <span class="error-message" id="username-error"></span>
    </div>

    <label for="password"><?php echo htmlspecialchars($data['translations']['password']); ?>:</label>
    <div class="input-wrapper">
        <input type="password" name="password" id="password" placeholder="<?php echo htmlspecialchars($data['translations']['typepass']); ?>">
        <span class="error-message" id="password-error"></span>
    </div>

    <div class="checkbox-container">
        <input type="checkbox" id="checkbox" name="checkbox">
        <label for="checkbox"><?php echo htmlspecialchars($data['translations']['rememberme']); ?></label>
    </div>

    <button type="submit"><?php echo htmlspecialchars($data['translations']['sumbit']); ?></button>
</form>

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
