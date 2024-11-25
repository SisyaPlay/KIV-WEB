<div class="main-container">
    <label class="center-label">Редактирование прав ролей</label>
    <form action="/edit_permissions/update_roles" method="post" class="role-form">
        <table class="edit-role-table">
            <thead>
                <tr>
                    <th>Выбрать</th>
                    <th>Название роли</th>
                    <th>Роль ID</th>
                    <th>Разрешение на чтение</th>
                    <th>Разрешение на создание</th>
                    <th>Разрешение на удаление</th>
                    <th>Писать комментарии</th>
                    <th>Редактировать права</th>
                    <th>Блокировать пользователей</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data)): ?>
                    <?php foreach ($data as $r): ?>
                        <tr>
                            <input type="hidden" name="id[<?php echo $r['id']; ?>]" value="<?php echo $r['id']; ?>">
                            <td>
                                <input type="checkbox" name="deleteRoles[]" value="<?php echo $r['id']; ?>">
                            </td>
                            <td>
                                <input type="text" name="roleName[<?php echo $r['id']; ?>]" class="form-control" value="<?php echo htmlspecialchars($r['name']); ?>" required>
                            </td>
                            <td><?php echo $r['id']; ?></td>
                            <td>
                                <input type="checkbox" name="allowRead[<?php echo $r['id']; ?>]" value="1" <?php echo $r['allowRead'] ? 'checked' : ''; ?>>
                            </td>
                            <td>
                                <input type="checkbox" name="allowCreate[<?php echo $r['id']; ?>]" value="1" <?php echo $r['allowCreate'] ? 'checked' : ''; ?>>
                            </td>
                            <td>
                                <input type="checkbox" name="allowDelete[<?php echo $r['id']; ?>]" value="1" <?php echo $r['allowDelete'] ? 'checked' : ''; ?>>
                            </td>
                            <td>
                                <input type="checkbox" name="allowWriteComm[<?php echo $r['id']; ?>]" value="1" <?php echo $r['allowWriteComm'] ? 'checked' : ''; ?>>
                            </td>
                            <td>
                                <input type="checkbox" name="editPermission[<?php echo $r['id']; ?>]" value="1" <?php echo $r['editPermission'] ? 'checked' : ''; ?>>
                            </td>
                            <td>
                                <input type="checkbox" name="allowBan[<?php echo $r['id']; ?>]" value="1" <?php echo $r['allowBan'] ? 'checked' : ''; ?>>
                            </td>
                            <td>
                                <input type="checkbox" name="givePermission[<?php echo $r['id']; ?>]" value="1" <?php echo $r['givePermission'] ? 'checked' : ''; ?>>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">Роли не найдены</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <button type="submit" name="updateRoles" class="btn btn-primary">Сохранить изменения</button>
        <button type="submit" name="deleteRolesBtn" class="btn btn-danger">Удалить выбранные роли</button>
        <button type="submit" name="createRoleBtn" class="btn btn-success">Создать новую роль</button>
    </form>
</div>
