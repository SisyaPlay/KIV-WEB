<form id="loginForm" action="/login/authenticate" method="post">
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

<?php if(isset($_SESSION['errors'])): ?>
    <script id="server-errors" type="application/json"><?= json_encode($_SESSION['errors']); ?></script>
<?php unset($_SESSION['errors']); ?>
<?php else: ?>
    <script id="server-errors" type="application/json">[]</script>
<?php endif; ?>
