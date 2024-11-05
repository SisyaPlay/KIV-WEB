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
        $role_id = $user['role'];
    } else {
        echo "User not found.";
        exit();
    }

    $roleQuery = $connect->prepare("SELECT * FROM roles");
    $roleQuery->execute();
    $roleResult = $roleQuery->get_result();

    $roles = $roleResult->fetch_all(MYSQLI_ASSOC); // Извлекаем все роли


    if (!empty($roles)) {
        // Пример использования прав для условий
        $allowRead = $roles[0]['allowRead'];
        $allowCreate = $roles[0]['allowCreate'];
        $allowDelete = $roles[0]['allowDelete'];
        $allowWriteComm = $roles[0]['allowWriteComm'];
        $editPermission = $roles[0]['editPermission'];
        $allowBan = $roles[0]['allowBan'];
    }

    $userRole = $connect->prepare("SELECT * FROM roles WHERE id = ?");
    $userRole->bind_param('i', $role_id);
    $userRole->execute();
    $userRoleResult = $userRole->get_result();

    if ($userRoleResult && $userRoleResult->num_rows > 0) {
        $role = $userRoleResult->fetch_assoc();
        $hasPermission = $role['editPermission'];
    }
    if($hasPermission != '1'){
        header("location: main.php");
        exit();
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
<div class="main-container">
    <label class="center-label">Редактирование прав ролей</label>

    <form action="../vendor/update_role_premissions.php" method="post" class="role-form">
        <table class="edit-role-table">
            <thead>
            <tr>
                <th>Выбрать</th>
                <th>Название роли</th>
                <th>Роль ID</th>
                <th>Разрешение на чтение</th>
                <th>Разрешение на создание</th>
                <th>Разрешение на удаление</th>
                <th>Писать комментарии</th>
                <th>Редактировать права</th>
                <th>Блокировать пользователей</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($roles)): ?>
                <?php foreach ($roles as $r): ?>
                    <tr>
                        <input type="hidden" name="id[<?php echo $r['id']; ?>]" value="<?php echo $r['id']; ?>">
                        <td>
                            <input type="checkbox" name="deleteRoles[]" value="<?php echo $r['id']; ?>">
                        </td>
                        <td>
                            <input type="text" name="roleName[<?php echo $r['id']; ?>]" class="form-control" value="<?php echo htmlspecialchars($r['name']); ?>" required>
                        </td>
                        <td><?php echo $r['id']; ?></td>
                        <td>
                            <input type="checkbox" name="allowRead[<?php echo $r['id']; ?>]" value="1" <?php echo $r['allowRead'] ? 'checked' : ''; ?>>
                        </td>
                        <td>
                            <input type="checkbox" name="allowCreate[<?php echo $r['id']; ?>]" value="1" <?php echo $r['allowCreate'] ? 'checked' : ''; ?>>
                        </td>
                        <td>
                            <input type="checkbox" name="allowDelete[<?php echo $r['id']; ?>]" value="1" <?php echo $r['allowDelete'] ? 'checked' : ''; ?>>
                        </td>
                        <td>
                            <input type="checkbox" name="allowWriteComm[<?php echo $r['id']; ?>]" value="1" <?php echo $r['allowWriteComm'] ? 'checked' : ''; ?>>
                        </td>
                        <td>
                            <input type="checkbox" name="editPermission[<?php echo $r['id']; ?>]" value="1" <?php echo $r['editPermission'] ? 'checked' : ''; ?>>
                        </td>
                        <td>
                            <input type="checkbox" name="allowBan[<?php echo $r['id']; ?>]" value="1" <?php echo $r['allowBan'] ? 'checked' : ''; ?>>
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
