<?php
    session_start();
    require_once 'connect.php';
    global $connect;

    // Проверяем, что данные отправлены через POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Обновление прав ролей и названий
        if (isset($_POST['updateRoles'])) {
            foreach ($_POST['allowCreate'] as $role_id => $allowCreate) {
                $allowDelete = $_POST['allowDelete'][$role_id];
                $allowWriteComm = $_POST['allowWriteComm'][$role_id];
                $editPermission = $_POST['editPermission'][$role_id];
                $allowBan = $_POST['allowBan'][$role_id];
                $roleName = $_POST['roleName'][$role_id];

                // Обновляем название роли и права роли
                $updateQuery = $connect->prepare("
                    UPDATE roles 
                    SET name = ?, allowCreate = ?, allowDelete = ?, allowWriteComm = ?, editPermission = ?, allowBan = ? 
                    WHERE id = ?
                ");
                $updateQuery->bind_param('siiiiii', $roleName, $allowCreate, $allowDelete, $allowWriteComm, $editPermission, $allowBan, $role_id);
                if (!$updateQuery->execute()) {
                    echo "Ошибка обновления роли с ID $role_id: " . $updateQuery->error;
                }
            }
        }

        // Удаление выбранных ролей
        if (isset($_POST['deleteRolesBtn']) && !empty($_POST['deleteRoles'])) {
            foreach ($_POST['deleteRoles'] as $role_id) {
                $deleteQuery = $connect->prepare("DELETE FROM roles WHERE id = ?");
                $deleteQuery->bind_param('i', $role_id);
                if (!$deleteQuery->execute()) {
                    echo "Ошибка удаления роли с ID $role_id: " . $deleteQuery->error;
                }
            }
        }

        // Создание новой роли
        if (isset($_POST['createRoleBtn'])) {
            $newRoleName = "New Role"; // Можно изменить по умолчанию
            $insertQuery = $connect->prepare("INSERT INTO roles (name, allowCreate, allowDelete, allowWriteComm, editPermission, allowBan) VALUES (?, 0, 0, 0, 0, 0)");
            $insertQuery->bind_param('s', $newRoleName);
            $insertQuery->execute();
        }

        // Перенаправление обратно на страницу
        header("Location: ../edit_roles.php");
        exit();
    }
?>
