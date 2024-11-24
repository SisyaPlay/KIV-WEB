<?php

class Model_Edit_Permissions extends Model {
    public function get_user_by_id($user_id) {
        $query = $this->mysql->prepare("SELECT * FROM users WHERE id = ?");
        $query->bind_param("i", $user_id);
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }

    public function get_role_by_id($role_id) {
        $query = $this->mysql->prepare("SELECT * FROM roles WHERE id = ?");
        $query->bind_param("i", $role_id);
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }

    public function get_all_roles() {
        $query = $this->mysql->query("SELECT * FROM roles");
        return $query->fetch_all(MYSQLI_ASSOC);
    }

    public function update_roles($data) {
        foreach ($data['id'] as $role_id) {
            $allowRead = isset($data['allowRead'][$role_id]) ? 1 : 0;
            $allowCreate = isset($data['allowCreate'][$role_id]) ? 1 : 0;
            $allowDelete = isset($data['allowDelete'][$role_id]) ? 1 : 0;
            $allowWriteComm = isset($data['allowWriteComm'][$role_id]) ? 1 : 0;
            $editPermission = isset($data['editPermission'][$role_id]) ? 1 : 0;
            $allowBan = isset($data['allowBan'][$role_id]) ? 1 : 0;
            $roleName = $data['roleName'][$role_id];

            $query = $this->mysql->prepare("
                UPDATE roles
                SET name = ?, allowRead = ?, allowCreate = ?, allowDelete = ?, allowWriteComm = ?, editPermission = ?, allowBan = ?
                WHERE id = ?
            ");
            $query->bind_param(
                'siiiiiii',
                $roleName,
                $allowRead,
                $allowCreate,
                $allowDelete,
                $allowWriteComm,
                $editPermission,
                $allowBan,
                $role_id
            );
            $query->execute();
        }
    }

    public function delete_roles($role_ids) {
        foreach ($role_ids as $role_id) {
            $query = $this->mysql->prepare("DELETE FROM roles WHERE id = ?");
            $query->bind_param("i", $role_id);
            $query->execute();
        }
    }

    public function create_new_role() {
        $newRoleName = "New Role";
        $query = $this->mysql->prepare("
            INSERT INTO roles (name, allowRead, allowCreate, allowDelete, allowWriteComm, editPermission, allowBan)
            VALUES (?, 0, 0, 0, 0, 0, 0)
        ");
        $query->bind_param("s", $newRoleName);
        $query->execute();
    }
}
