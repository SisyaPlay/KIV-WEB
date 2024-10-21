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

    // Извлекаем все данные о ролях сразу
    $roles = $roleResult->fetch_all(MYSQLI_ASSOC);

    if (!empty($roles)) {
        // Пример использования прав для условий
        $allowCreate = $roles[0]['allowCreate'];
        $allowDelete = $roles[0]['allowDelete'];
        $allowWriteComm = $roles[0]['allowWriteComm'];
        $editPermission = $roles[0]['editPermission'];
        $allowBan = $roles[0]['allowBan'];
    }

    if($editPermission != '1'){
        header("location: index.php");
        exit();
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

<!-- Навбар -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">Project-M</a>
        <div class="mx-auto order-0">
            <ul class="navbar-nav" style="display: flex; justify-content: center; width: 100%;">
                <li class="nav-item">
                    <a class="nav-link" href="index.php"><i class="fas fa-home"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-images"></i> Album</a>
                </li>
            </ul>
        </div>
        <div class="navbar-nav ml-auto">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a class="nav-link" href="profile.php" id="userProfileLink" aria-expanded="false">
                    <img src="<?php echo $picture ?>" alt="User Avatar" class="user-avatar" />
                </a>
                <select class="form-control" id="languageSelect">
                    <option value="en">English</option>
                    <option value="ru">Русский</option>
                </select>
            <?php else: ?>
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

<div class="main-container">
    <h2>Редактирование прав ролей</h2>
    <form action="vendor/update_role_premissions.php" method="post" class="role-form">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Выбрать</th>
                <th>Название роли</th>
                <th>Роль ID</th>
                <th>Разрешение на создание</th>
                <th>Разрешение на удаление</th>
                <th>Писать комментарии</th>
                <th>Редактировать права</th>
                <th>Блокировать пользователей</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($roles)): ?>
                <?php foreach ($roles as $role): ?>
                    <tr>
                        <td>
                            <input type="checkbox" name="deleteRoles[]" value="<?php echo $role['id']; ?>">
                        </td>
                        <td>
                            <input type="text" name="roleName[<?php echo $role['id']; ?>]" class="form-control" value="<?php echo htmlspecialchars($role['name']); ?>" required>
                        </td>
                        <td><?php echo $role['id']; ?></td>
                        <td>
                            <select name="allowCreate[<?php echo $role['id']; ?>]" class="form-control">
                                <option value="1" <?php echo $role['allowCreate'] ? 'selected' : ''; ?>>Разрешено</option>
                                <option value="0" <?php echo !$role['allowCreate'] ? 'selected' : ''; ?>>Запрещено</option>
                            </select>
                        </td>
                        <td>
                            <select name="allowDelete[<?php echo $role['id']; ?>]" class="form-control">
                                <option value="1" <?php echo $role['allowDelete'] ? 'selected' : ''; ?>>Разрешено</option>
                                <option value="0" <?php echo !$role['allowDelete'] ? 'selected' : ''; ?>>Запрещено</option>
                            </select>
                        </td>
                        <td>
                            <select name="allowWriteComm[<?php echo $role['id']; ?>]" class="form-control">
                                <option value="1" <?php echo $role['allowWriteComm'] ? 'selected' : ''; ?>>Разрешено</option>
                                <option value="0" <?php echo !$role['allowWriteComm'] ? 'selected' : ''; ?>>Запрещено</option>
                            </select>
                        </td>
                        <td>
                            <select name="editPermission[<?php echo $role['id']; ?>]" class="form-control">
                                <option value="1" <?php echo $role['editPermission'] ? 'selected' : ''; ?>>Разрешено</option>
                                <option value="0" <?php echo !$role['editPermission'] ? 'selected' : ''; ?>>Запрещено</option>
                            </select>
                        </td>
                        <td>
                            <select name="allowBan[<?php echo $role['id']; ?>]" class="form-control">
                                <option value="1" <?php echo $role['allowBan'] ? 'selected' : ''; ?>>Разрешено</option>
                                <option value="0" <?php echo !$role['allowBan'] ? 'selected' : ''; ?>>Запрещено</option>
                            </select>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">Роли не найдены</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>

        <button type="submit" name="updateRoles" class="btn btn-primary">Сохранить изменения</button>
        <button type="submit" name="deleteRolesBtn" class="btn btn-danger">Удалить выбранные роли</button>
        <button type="submit" name="createRoleBtn" class="btn btn-success">Создать новую роль</button>
    </form>
</div>

<script src="assets/js/bootstrap.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="assets/js/fontawesome.js" crossorigin="anonymous"></script>
</body>
</html>
