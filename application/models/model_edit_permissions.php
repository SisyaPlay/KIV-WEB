<?php

class Model_Edit_Permissions extends Model {
    public function getUserById($user_id) {
        $query = $this->mysql->prepare("SELECT * FROM users WHERE id = ?");
        $query->bind_param("i", $user_id);
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }

    public function getRoleById($role_id) {
        $query = $this->mysql->prepare("SELECT * FROM roles WHERE id = ?");
        $query->bind_param("i", $role_id);
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }

    public function getAllRoles() {
        $query = $this->mysql->query("SELECT * FROM roles");
        return $query->fetch_all(MYSQLI_ASSOC);
    }

    public function updateRoles($data) {
        foreach ($data['id'] as $role_id) {
            $allowRead = isset($data['allowRead'][$role_id]) ? 1 : 0;
            $allowCreate = isset($data['allowCreate'][$role_id]) ? 1 : 0;
            $allowDelete = isset($data['allowDelete'][$role_id]) ? 1 : 0;
            $allowWriteComm = isset($data['allowWriteComm'][$role_id]) ? 1 : 0;
            $editPermission = isset($data['editPermission'][$role_id]) ? 1 : 0;
            $allowBan = isset($data['allowBan'][$role_id]) ? 1 : 0;
            $givePermission = isset($data['givePermission'][$role_id]) ? 1 : 0;
            $roleName = $data['roleName'][$role_id];

            $query = $this->mysql->prepare("
                UPDATE roles
                SET name = ?, allowRead = ?, allowCreate = ?, allowDelete = ?, allowWriteComm = ?, editPermission = ?, allowBan = ?, givePermission = ?
                WHERE id = ?
            ");
            $query->bind_param(
                'siiiiiiii',
                $roleName,
                $allowRead,
                $allowCreate,
                $allowDelete,
                $allowWriteComm,
                $editPermission,
                $allowBan,
                $givePermission,
                $role_id
            );
            $query->execute();
        }
    }

    public function deleteRoles($role_ids) {
        foreach ($role_ids as $role_id) {
            $query = $this->mysql->prepare("DELETE FROM roles WHERE id = ?");
            $query->bind_param("i", $role_id);
            $query->execute();
        }
    }

    public function createNewRole() {
        $newRoleName = "New Role";
        $query = $this->mysql->prepare("
            INSERT INTO roles (name, allowRead, allowCreate, allowDelete, allowWriteComm, editPermission, allowBan, givePermission)
            VALUES (?, 0, 0, 0, 0, 0, 0, 0)
        ");
        $query->bind_param("s", $newRoleName);
        $query->execute();
    }
}
