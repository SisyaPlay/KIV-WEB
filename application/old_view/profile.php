<?php
    session_start();
    $user_id = $_SESSION['user_id'];
    global $connect;
    require_once 'vendor/connect.php';

    if (!isset($_SESSION['user_id'])) {
        header("location: main.php");
        exit();
    }

    // Получаем информацию о пользователе
    $query = $connect->prepare("SELECT * FROM users WHERE id = ?");
    $query->bind_param('i', $user_id);
    $query->execute();
    $result = $query->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $picture = $user['picture'];
        $role = $user['role'];
    } else {
        echo "User not found.";
        exit();
    }

    $roleQuery = $connect->prepare("SELECT * FROM roles WHERE id = ?");
    $roleQuery->bind_param('i', $role);
    $roleQuery->execute();
    $roleResult = $roleQuery->get_result();

    if ($roleResult && $roleResult->num_rows > 0) {
        // Извлекаем данные о роли
        $roleData = $roleResult->fetch_assoc();

        // Пример использования прав для условий
        $allowCreate = $roleData['allowCreate'];
        $allowDelete = $roleData['allowDelete'];
        $allowWriteComm = $roleData['allowWriteComm'];
        $editPermission = $roleData['editPermission'];
        $allowBan = $roleData['allowBan'];
    }
    include 'assets/php/navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile - Project-m Blog</title>
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <!-- Основное содержимое профиля -->
    <div class="main-container">
        <div class="row">
            <div class="col-md-4">
                <!-- Аватар пользователя -->
                <div class="profile-pic">
                    <img src="<?php echo $picture ?>" alt="User Avatar" class="img-thumbnail"style="width: 322px; height: 322px;">
                    <form action="../vendor/upload_avatar.php" method="post" enctype="multipart/form-data" class="mt-3">
                        <input type="file" name="avatar" accept="image/*" class="form-control">
                        <button type="submit" class="btn btn-primary mt-2">Change Avatar</button>
                    </form>
                </div>
            </div>

            <div class="col-md-8">
                <!-- Информация пользователя -->
                <h3><?php echo $user['username']; ?></h3>
                <p>Email: <?php echo $user['email']; ?></p>
                <p>Role: <?php echo $user['role']; ?></p>

                <!-- Проверка прав на редактирование ролей -->
                <?php if ($editPermission): ?>
                    <a href="edit_roles.php" class="btn btn-warning mt-3">Edit Permissions</a>
                <?php endif; ?>

                <!-- Проверка прав на бан пользователей -->
                <?php if ($allowBan): ?>
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

<script src="../assets/js/bootstrap.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="../assets/js/fontawesome.js" crossorigin="anonymous"></script>
</body>
</html>
