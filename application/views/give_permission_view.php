<div class="main-container">
    <label class="center-label"><?php echo htmlspecialchars($data['translations']['changerole']); ?></label>

    <form action="/give_permission/update_roles" method="post" class="role-form">
        <table border="1" class="edit-role-table">
            <thead>
                <tr>
                    <th><?php echo htmlspecialchars($data['translations']['id']); ?></th>
                    <th><?php echo htmlspecialchars($data['translations']['username']); ?></th>
                    <th><?php echo htmlspecialchars($data['translations']['role']); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data['users'])): ?>
                    <?php foreach ($data['users'] as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user[0] ?? 'Не указано'); ?></td>
                            <td><?php echo htmlspecialchars($user[1] ?? 'Не указано'); ?></td>
                            <td>
                                <!-- Имя select: roles[user_id][role_id] -->
                                <select name="roles[<?php echo htmlspecialchars($user[0] ?? ''); ?>]" class="form-select">
                                    <?php if (!empty($data['roles'])): ?>
                                        <?php foreach ($data['roles'] as $role): ?>
                                            <option value="<?php echo htmlspecialchars($role[0] ?? ''); ?>"
                                                <?php echo ($user[2] == $role[0]) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($role[1] ?? 'Не указано'); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <option disabled><?php echo htmlspecialchars($data['translations']['rolesnotfound']); ?></option>
                                    <?php endif; ?>
                                </select>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3"><?php echo htmlspecialchars($data['translations']['usernotfound']); ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary"><?php echo htmlspecialchars($data['translations']['savechanges']); ?></button>
    </form>
</div>
