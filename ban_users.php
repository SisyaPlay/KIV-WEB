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

    if($allowBan != '1'){
        header("location: index.php");
        exit();
    }

    $usersQuery = $connect->prepare("SELECT * FROM users where id != ?");
    $usersQuery->bind_param('i', $user_id);
    $usersQuery->execute();
    $usersResult = $usersQuery->get_result();

    $users = $usersResult->fetch_all(MYSQLI_ASSOC);

    include 'assets/php/navbar.php';
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

    <div class="main-container">
        <label class="center-label">Забанить/Разбанить пользователей</label>

        <form action="vendor/ban_user.php" method="post" class="role-form">
            <table class="edit-role-table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Никнейм</th>
                    <th>Забанить</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <input type="hidden" name="id[<?php echo $user['id']; ?>]" value="<?php echo $user['id']; ?>">
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo $user['username']; ?></td>
                            <td>
                                <input type="checkbox" name="banUsers[]" value="<?php echo $user['id']; ?>" <?php echo $user['role'] == 5 ? 'checked' : ''; ?>>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">Пользователи не найдены</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>

            <button type="submit" name="updateUser" class="btn btn-primary">Сохранить изменения</button>
        </form>
    </div>

<script src="assets/js/bootstrap.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="assets/js/fontawesome.js" crossorigin="anonymous"></script>
</body>
</html>
