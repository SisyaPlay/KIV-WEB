<div class="main-container">
    <label class="center-label"><?php echo htmlspecialchars($data['translations']['editroles']); ?></label>
    <form action="/edit_permissions/update_roles" method="post" class="role-form">
        <table class="edit-role-table">
            <thead>
                <tr>
                    <th><?php echo htmlspecialchars($data['translations']['select']); ?></th>
                    <th><?php echo htmlspecialchars($data['translations']['rolename']); ?></th>
                    <th><?php echo htmlspecialchars($data['translations']['roleid']); ?></th>
                    <th><?php echo htmlspecialchars($data['translations']['allowread']); ?></th>
                    <th><?php echo htmlspecialchars($data['translations']['allowcreate']); ?></th>
                    <th><?php echo htmlspecialchars($data['translations']['allowdelete']); ?></th>
                    <th><?php echo htmlspecialchars($data['translations']['allowwritecomm']); ?></th>
                    <th><?php echo htmlspecialchars($data['translations']['editpermissions']); ?></th>
                    <th><?php echo htmlspecialchars($data['translations']['allowbanusers']); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data['roles'])): ?>
                    <?php foreach ($data['roles'] as $r): ?>
                        <tr>
                            <input type="hidden" name="id[<?php echo $r['id']; ?>]" value="<?php echo $r['id']; ?>">
                            <td>
                                <input type="checkbox" name="deleteRoles[]" value="<?php echo $r['id']; ?>">
                            </td>
                            <td>
                                <input type="text" name="roleName[<?php echo $r['id']; ?>]" class="form-control" value="<?php echo htmlspecialchars($r['name']); ?>" required style="width: 150px;">
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
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8"><?php echo htmlspecialchars($data['translations']['rolesnotfound']); ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <button type="submit" name="updateRoles" class="btn btn-primary">
            <?php echo htmlspecialchars($data['translations']['savechanges']); ?>
        </button>
        <button type="submit" name="deleteRolesBtn" class="btn btn-danger">
            <?php echo htmlspecialchars($data['translations']['deleteroles']); ?>
        </button>
        <button type="submit" name="createRoleBtn" class="btn btn-success">
            <?php echo htmlspecialchars($data['translations']['createrole']); ?>
        </button>
    </form>
</div>
