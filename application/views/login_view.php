<form id="loginForm" action="/login" method="post">
    <input type="hidden" name="redirect_to" value="login_page">
    <label for="username">Username:</label>
    <div class="input-wrapper">
        <input type="text" name="username" id="username" placeholder="Type your username">
        <span class="error-message" id="username-error"></span>
    </div>

    <label for="password">Password:</label>
    <div class="input-wrapper">
        <input type="password" name="password" id="password" placeholder="Type your password">
        <span class="error-message" id="password-error"></span>
    </div>

    <div class="checkbox-container">
        <input type="checkbox" id="checkbox" name="checkbox">
        <label for="checkbox">Remember me</label>
    </div>

    <button type="submit">Submit</button>
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
