<?php

Class Model_Give_Permission extends Model {
  public function getRoleById($user_id) {
      // Первый запрос: получение роли пользователя
      $query = $this->mysql->prepare("SELECT role FROM users WHERE id = ?");
      $query->bind_param("i", $user_id);
      $query->execute();

      $userResult = $query->get_result()->fetch_assoc();
      if ($userResult && isset($userResult['role'])) {
          $role_id = $userResult['role'];

          // Второй запрос: получение данных роли
          $roleQuery = $this->mysql->prepare("SELECT * FROM roles WHERE id = ?");
          $roleQuery->bind_param("i", $role_id);
          $roleQuery->execute();

          return $roleQuery->get_result()->fetch_assoc();
      }

      // Если роль не найдена, вернуть null или пустое значение
      return null;
    }


    public function getAllUsers() {
        $query = $this->mysql->prepare("SELECT id, username, role FROM users");
        $query->execute();
        return $query->get_result()->fetch_all();
    }

    public function getAllRoles() {
        $query = $this->mysql->prepare("SELECT id, name FROM roles");
        $query->execute();
        return $query->get_result()->fetch_all();
    }

    public function updateUserRoles($roles) {
        // Перебираем каждого пользователя и его роль
        foreach ($roles as $user_id => $role_id) {
            // Обновляем роль для каждого пользователя
            $query = $this->mysql->prepare("UPDATE users SET role = ? WHERE id = ?");
            $query->bind_param("ii", $role_id, $user_id);
            $query->execute();
        }
    }


}
