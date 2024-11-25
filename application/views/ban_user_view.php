<div class="main-container">
    <label class="center-label">Забанить/Разбанить пользователей</label>

    <form action="/ban_user/ban_user" method="post" class="role-form">
            <table class="edit-role-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Никнейм</th>
                        <th>Забанить</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data)): ?>
                        <?php foreach ($data as $user): ?>
                            <tr>
                                <input type="hidden" name="id[<?php echo $user['id']; ?>]" value="<?php echo $user['id']; ?>">
                                <td><?php echo $user['id']; ?></td>
                                <td><?php echo $user['username']; ?></td>
                                <td>
                                    <input type="checkbox" name="banUsers[]" value="<?php echo $user['id']; ?>" <?php echo $user['role'] == 5 ? 'checked' : ''; ?>>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8">Пользователи не найдены</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <button type="submit" name="updateUser" class="btn btn-primary">Сохранить изменения</button>
        </form>
</div>
