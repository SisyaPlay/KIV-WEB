<?php

class Model_Ban_User extends Model {
    // Получение информации о пользователе
    public function getUserData($user_id) {
        $query = $this->mysql->prepare("SELECT * FROM users WHERE id = ?");
        $query->bind_param('i', $user_id);
        $query->execute();
        $result = $query->get_result();
        return $result->fetch_assoc();
    }

    public function getRoleById($role_id) {
        $query = $this->mysql->prepare("SELECT * FROM roles WHERE id = ?");
        $query->bind_param("i", $role_id);
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }

    // Получение всех пользователей, которых можно забанить
    public function getUsersToBan($current_user_id) {
        $query = $this->mysql->prepare("SELECT * FROM users WHERE id != ?");
        $query->bind_param('i', $current_user_id);
        $query->execute();
        $result = $query->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Обновление статуса бана пользователей
    public function updateBanStatus($bannedUsers, $current_user_id) {
        // Устанавливаем роль = 5 для забаненных пользователей
        foreach ($bannedUsers as $user_id) {
            $updateQuery = $this->mysql->prepare("UPDATE users SET role = 5 WHERE id = ?");
            $updateQuery->bind_param('i', $user_id);
            $updateQuery->execute();
        }

        // Разбаниваем пользователей, которых не выбрали для бана
        $unbanQuery = $this->mysql->prepare("SELECT id FROM users WHERE role = 5 AND id != ?");
        $unbanQuery->bind_param('i', $current_user_id);
        $unbanQuery->execute();
        $unbanResult = $unbanQuery->get_result();

        while ($user = $unbanResult->fetch_assoc()) {
            if (!in_array($user['id'], $bannedUsers)) {
                $updateRoleQuery = $this->mysql->prepare("UPDATE users SET role = 0 WHERE id = ?");
                $updateRoleQuery->bind_param('i', $user['id']);
                $updateRoleQuery->execute();
            }
        }
    }
}
