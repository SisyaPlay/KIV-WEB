<?php
    session_start();
    require_once 'connect.php';
    global $connect;

    // Проверяем, что данные отправлены через POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Обновление прав ролей и названий
        if (isset($_POST['updateRoles'])) {
            foreach ($_POST['id'] as $role_id) {
                $allowRead = isset($_POST['allowRead'][$role_id]) ? 1 : 0;
                $allowCreate = isset($_POST['allowCreate'][$role_id]) ? 1 : 0;
                $allowDelete = isset($_POST['allowDelete'][$role_id]) ? 1 : 0;
                $allowWriteComm = isset($_POST['allowWriteComm'][$role_id]) ? 1 : 0;
                $editPermission = isset($_POST['editPermission'][$role_id]) ? 1 : 0;
                $allowBan = isset($_POST['allowBan'][$role_id]) ? 1 : 0;
                $roleName = $_POST['roleName'][$role_id];


                // Обновляем название роли и права роли
                $updateQuery = $connect->prepare("
                    UPDATE roles 
                    SET name = ?, allowRead = ?,allowCreate = ?, allowDelete = ?, allowWriteComm = ?, editPermission = ?, allowBan = ? 
                    WHERE id = ?
                ");
                $updateQuery->bind_param('siiiiiii', $roleName, $allowRead, $allowCreate, $allowDelete, $allowWriteComm, $editPermission, $allowBan, $role_id);
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
            $insertQuery = $connect->prepare("INSERT INTO roles (name, allowRead, allowCreate, allowDelete, allowWriteComm, editPermission, allowBan) VALUES (?, 0, 0, 0, 0, 0)");
            $insertQuery->bind_param('s', $newRoleName);
            $insertQuery->execute();
        }

        // Перенаправление обратно на страницу
        header("Location: ../edit_roles.php");
        exit();
    }
?>
