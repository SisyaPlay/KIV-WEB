<?php
session_start();
require_once 'connect.php';
global $connect;

// Проверяем, что данные отправлены через POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Обновляем пользователей, которые должны быть забанены (роль = 5)
    $bannedUsers = isset($_POST['banUsers']) ? $_POST['banUsers'] : [];

    if (isset($_POST['updateUser'])) {
        // Устанавливаем роль = 5 для выбранных пользователей
        foreach ($bannedUsers as $user_id) {
            $updateQuery = $connect->prepare("UPDATE users SET role = 5 WHERE id = ?");
            $updateQuery->bind_param('i', $user_id);
            if (!$updateQuery->execute()) {
                echo "Ошибка бана с ID $user_id: " . $updateQuery->error;
            }
        }

        // Выбираем пользователей, у которых роль = 5, но они не выбраны для бана, и снимаем бан (устанавливаем роль = 0)
        $unbanQuery = $connect->prepare("SELECT id FROM users WHERE role = 5 AND id != ?");
        $unbanQuery->bind_param('i', $_SESSION['user_id']);
        $unbanQuery->execute();
        $unbanResult = $unbanQuery->get_result();

        if ($unbanResult->num_rows > 0) {
            while ($user = $unbanResult->fetch_assoc()) {
                if (!in_array($user['id'], $bannedUsers)) {
                    $updateRoleQuery = $connect->prepare("UPDATE users SET role = 0 WHERE id = ?");
                    $updateRoleQuery->bind_param('i', $user['id']);
                    $updateRoleQuery->execute();
                }
            }
        }
    }

    // Перенаправление обратно на страницу
    header("Location: ../ban_users.php");
    exit();
}
?>
