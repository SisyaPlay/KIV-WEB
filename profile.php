<?php
    session_start();
    $user_id = $_SESSION['user_id'];
    global $connect;
    require_once 'vendor/connect.php';

    if (!isset($_SESSION['user_id'])) {
        header("location: index.php");
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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile - Project-m Blog</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css"  integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<div class="background"></div>

<!-- Навбар (тот же, что и раньше) -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <!-- Лейбл слева -->
        <a class="navbar-brand" href="#">Project-M</a>

        <!-- Вкладки по центру -->
        <div class="mx-auto order-0">
            <ul class="navbar-nav" style="display: flex; justify-content: center; width: 100%;">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">
                        <i class="fas fa-home"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-images"></i> Album
                    </a>
                </li>
            </ul>
        </div>

        <!-- Кнопки справа -->
        <div class="navbar-nav ml-auto">
            <?php if (isset($_SESSION['user_id'])): ?>
                <!-- Отображаем аватар пользователя -->
                <a class="nav-link" href="profile.php" id="userProfileLink" aria-expanded="false">
                    <img src="<?php echo $picture ?>" alt="User Avatar" class="user-avatar" />
                </a>

                <!-- Комбобокс для смены языка -->
                <select class="form-control" id="languageSelect">
                    <option value="en">English</option>
                    <option value="ru">Русский</option>
                </select>

            <?php else: ?>
                <!-- Кнопка для открытия модального окна входа -->
                <a class="nav-link" href="#" id="signInBtn">Sign In</a>
                <div class="dropdown-login" id="loginDropdown" style="display: none;">
                    <div class="dropdown-login-content">
                        <form id="loginForm" action="vendor/signin.php" method="post">
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
                                <label for="checkbox" class="checkbox-container">Remember me</label>
                            </div>

                            <button type="submit">Submit</button>
                        </form>
                    </div>
                </div>
                <a class="nav-link" href="register.php">Sign Up</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<!-- Основное содержимое профиля -->
<div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
            <!-- Аватар пользователя -->
            <div class="profile-pic">
                <img src="<?php echo $picture ?>" alt="User Avatar" class="img-thumbnail">
                <form action="vendor/upload_avatar.php" method="post" enctype="multipart/form-data" class="mt-3">
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

<script src="assets/js/bootstrap.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="assets/js/fontawesome.js" crossorigin="anonymous"></script>
</body>
</html>
