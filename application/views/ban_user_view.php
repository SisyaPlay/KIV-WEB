<div class="main-container">
    <label class="center-label"><?php echo htmlspecialchars($data['translations']['banunban']); ?></label>

    <form action="/ban_user/ban_user" method="post" class="role-form">
            <table class="edit-role-table">
                <thead>
                    <tr>
                        <th><?php echo htmlspecialchars($data['translations']['id']); ?></th>
                        <th><?php echo htmlspecialchars($data['translations']['username']); ?></th>
                        <th><?php echo htmlspecialchars($data['translations']['ban']); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data['users'])): ?>
                        <?php foreach ($data['users'] as $user): ?>
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
                            <td colspan="8"><?php echo htmlspecialchars($data['translations']['usernotfound']); ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <button type="submit" name="updateUser" class="btn btn-primary"><?php echo htmlspecialchars($data['translations']['savechanges']); ?></button>
        </form>
</div>
