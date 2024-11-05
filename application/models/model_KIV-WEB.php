<?php

class model_Main extends model {
    public function getUserById($userId) {
        $query = $this->mysql->prepare("SELECT * FROM users WHERE id = ?");
        $query->bind_param('i', $userId);
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }

    public function getUserRole($roleId) {
        $query = $this->mysql->prepare("SELECT * FROM roles WHERE id = ?");
        $query->bind_param('i', $roleId);
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }
}