<!-- Основное содержимое профиля -->
<div class="main-container">
    <div class="row">
        <div class="col-md-4">
            <!-- Аватар пользователя -->
            <div class="profile-pic">
                <img src="<?php echo $_SESSION['picture']; ?>" alt="User Avatar" class="img-thumbnail"style="width: 322px; height: 322px;">
                <form action="/upload_avatar" method="post" enctype="multipart/form-data" class="mt-3">
                    <input type="file" name="avatar" accept="image/*" class="form-control">
                    <button type="submit" class="btn btn-primary mt-2">Change Avatar</button>
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <!-- Информация пользователя -->
            <h3><?php echo $data['user']['username']; ?></h3>
            <p>Email: <?php echo $data['user']['email']; ?></p>
            <p>Role: <?php echo $data['user']['role']; ?></p>

            <!-- Проверка прав на редактирование ролей -->
            <?php if ($data['permissions']['editPermission']): ?>
                <a href="/edit_permissions" class="btn btn-warning mt-3">Edit Permissions</a>
            <?php endif; ?>

            <!-- Проверка прав на бан пользователей -->
            <?php if ($data['permissions']['allowBan']): ?>
                <a href="ban_users.php" class="btn btn-danger mt-3">Ban Users</a>
            <?php endif; ?>
        </div>
    </div>
</div>

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
