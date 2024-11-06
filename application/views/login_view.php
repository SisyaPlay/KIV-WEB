<form id="signupForm" action="" method="post">
    <label>Username</label>
    <div class="input-wrapper">
        <input type="text" name="username" id="username-" placeholder="Type your username">
        <span class="error-message" id="username--error"></span>
    </div>

    <label>Password</label>
    <div class="input-wrapper">
        <input type="password" name="password" id="password-" placeholder="Type your password">
        <span class="error-message" id="password--error"></span>
    </div>

    <button type="submit">Sign in</button>
</form>

<!-- Включение JavaScript -->
<script src="application/assets/js/signinValidation.js"></script>
<script src="application/assets/js/login.js"></script>

<?php if(isset($_SESSION['errors'])): ?>
    <script id="server-errors" type="application/json"><?= json_encode($_SESSION['errors']); ?></script>
<?php unset($_SESSION['errors']); ?>
<?php else: ?>
    <script id="server-errors" type="application/json">[]</script>
<?php endif; ?>

<?php
if(@$_SESSION['registered']) {
    echo '<p class="registeredMessage">' . $_SESSION['registered']. '</p>';
    echo '<script>
                setTimeout(function() {
                    var message = document.querySelector(".registeredMessage");
                    if (message) {
                        message.classList.add("fadeOut");
                    }
                }, 1000);
              </script>';
}
unset($_SESSION['registered']);
?>

<?php
if(@$_SESSION['massage']) {
    echo '<p class="msg">' . $_SESSION['massage']. '</p>';
    echo '<script>
                setTimeout(function() {
                    var message = document.querySelector(".msg");
                    if (message) {
                        message.classList.add("fadeOut");
                    }
                }, 1000);
              </script>';
}
unset($_SESSION['massage']);
?>
