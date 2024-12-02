<form id="signupForm" action="/register" method="post">
    <label><?php echo htmlspecialchars($data['translations']['username']); ?></label>
    <div class="input-wrapper">
        <input type="text" name="username" id="username-" placeholder="<?php echo htmlspecialchars($data['translations']['typename']); ?>">
        <span class="error-message" id="username--error"></span>
    </div>

    <label><?php echo htmlspecialchars($data['translations']['email']); ?></label>
    <div class="input-wrapper">
        <input type="email" name="email" id="email" placeholder="<?php echo htmlspecialchars($data['translations']['typeemail']); ?>">
        <span class="error-message" id="email-error"></span>
    </div>

    <label><?php echo htmlspecialchars($data['translations']['password']); ?></label>
    <div class="input-wrapper">
        <input type="password" name="password" id="password-" placeholder="<?php echo htmlspecialchars($data['translations']['typepass']); ?>">
        <span class="error-message" id="password--error"></span>
    </div>

    <label><?php echo htmlspecialchars($data['translations']['comfirmpass']); ?></label>
    <div class="input-wrapper">
        <input type="password" name="password_confirm" id="password_confirm" placeholder="<?php echo htmlspecialchars($data['translations']['typecomfpass']); ?>">
        <span class="error-message" id="password_confirm-error"></span>
    </div>

    <button type="submit"><?php echo htmlspecialchars($data['translations']['signup']); ?></button>
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
