<?php

class Model_Profile extends Model {
    public function get_user_permissions($user_id) {
        if ($user_id) {
            $userQuery = $this->mysql->prepare("SELECT u.picture, r.*
                                            FROM users u
                                            JOIN roles r ON u.role = r.id
                                            WHERE u.id = ?");
            $userQuery->bind_param("i", $user_id);
            $userQuery->execute();
            return $userQuery->get_result()->fetch_assoc();
        }

        return [
            'allowWriteComm' => false,
            'allowCreate' => false,
            'allowDelete' => false,
            'editPermission' => false,
            'allowBan' => false
        ];
    }

    public function get_user_info($user_id) {
        if ($user_id) {
            $query = $this->mysql->prepare("SELECT * from users where id = ?");
            $query->bind_param("i", $user_id);
            $query->execute();

            return $query->get_result()->fetch_assoc();
        }
    }
}
