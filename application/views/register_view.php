<form id="signupForm" action="/register" method="post">
    <label>Username</label>
    <div class="input-wrapper">
        <input type="text" name="username" id="username-" placeholder="Type your username">
        <span class="error-message" id="username--error"></span>
    </div>

    <label>e-mail</label>
    <div class="input-wrapper">
        <input type="email" name="email" id="email" placeholder="Type your email">
        <span class="error-message" id="email-error"></span>
    </div>

    <label>Password</label>
    <div class="input-wrapper">
        <input type="password" name="password" id="password-" placeholder="Type your password">
        <span class="error-message" id="password--error"></span>
    </div>

    <label>Confirm password</label>
    <div class="input-wrapper">
        <input type="password" name="password_confirm" id="password_confirm" placeholder="Confirm your password">
        <span class="error-message" id="password_confirm-error"></span>
    </div>

    <button type="submit">Sign up</button>
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

<!-- Включение JavaScript -->
<script src="application/assets/js/signupValidation.js"></script>
