<div class="main-container">
    <div class="row">
        <div class="col-md-4">
            <!-- Аватар пользователя -->
            <div class="profile-pic">
                <img src="<?php echo $_SESSION['picture']; ?>" alt="User Avatar" class="img-thumbnail" style="width: 322px; height: 322px;">
                <form action="/profile/upload_avatar" method="post" enctype="multipart/form-data" class="mt-3">
                    <input type="file" name="avatar" accept="image/*" class="form-control">
                    <button type="submit" class="btn btn-primary mt-2">
                        <?php echo htmlspecialchars($data['translations']['changeavatar']); ?>
                    </button>
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <div>
              <!-- Информация пользователя -->
              <h3 class="center-label"><?php echo $data['user']['username']; ?></h3>
              <p><?php echo htmlspecialchars($data['translations']['email']); ?>: <?php echo $data['user']['email']; ?></p>
              <p><?php echo htmlspecialchars($data['translations']['role']); ?>: <?php echo $data['user']['role']; ?></p>

              <?php if ($data['permissions']['givePermission']): ?>
                  <a href="/give_permission" class="btn btn-primary mt-3">
                      <?php echo htmlspecialchars($data['translations']['givepermissions']); ?>
                  </a>
              <?php endif; ?>

              <!-- Проверка прав на редактирование ролей -->
              <?php if ($data['permissions']['editPermission']): ?>
                  <a href="/edit_permissions" class="btn btn-warning mt-3">
                      <?php echo htmlspecialchars($data['translations']['editpermissions']); ?>
                  </a>
              <?php endif; ?>

              <!-- Проверка прав на бан пользователей -->
              <?php if ($data['permissions']['allowBan']): ?>
                  <a href="/ban_user" class="btn btn-danger mt-3">
                      <?php echo htmlspecialchars($data['translations']['banusers']); ?>
                  </a>
              <?php endif; ?>

              <div>
                <?php if ($data['permissions']['allowCreate']): ?>
                  <table class="edit-role-table">
                      <thead>
                          <tr>
                              <th>ID</th>
                              <th><?php echo htmlspecialchars($data['translations']['articlename']); ?></th>
                              <th><?php echo htmlspecialchars($data['translations']['deleting']); ?></th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php if (!empty($data['articles'])): ?>
                              <?php foreach ($data['articles'] as $article): ?>
                                  <tr>
                                      <td><?= htmlspecialchars($article[0]) ?></td>
                                      <td><?= htmlspecialchars($article[1]) ?></td>
                                      <td>
                                          <button class="btn btn-danger btn-sm" onclick="confirmDeletion(<?= $article[0] ?>)">
                                              <?php echo htmlspecialchars($data['translations']['delete']); ?>
                                          </button>
                                      </td>
                                  </tr>
                              <?php endforeach; ?>
                          <?php else: ?>
                              <tr>
                                  <td colspan="3"><?php echo htmlspecialchars($data['translations']['articlenotfound']); ?></td>
                              </tr>
                          <?php endif; ?>
                      </tbody>
                  </table>
                <?php endif; ?>
              </div>
          </div>
      </div>
  </div>

<?php
if (@$_SESSION['registered']) {
    echo '<p class="registeredMessage">' . htmlspecialchars($_SESSION['registered']) . '</p>';
    echo '<script>
                    setTimeout(function() {
                        var message = document.querySelector(".registeredMessage");
                        if (message) {
                            message.classList.add("fadeOut");
                        }
                    }, 1000);
                  </script>';
}
unset($_SESSION['registered']);
?>

<?php
if (@$_SESSION['massage']) {
    echo '<p class="msg">' . htmlspecialchars($_SESSION['massage']) . '</p>';
    echo '<script>
                    setTimeout(function() {
                        var message = document.querySelector(".msg");
                        if (message) {
                            message.classList.add("fadeOut");
                        }
                    }, 1000);
                  </script>';
}
unset($_SESSION['massage']);
?>

<script>
  const sureToDeleteMessage = "<?php echo addslashes($data['translations']['suretodelete']); ?>";
  function confirmDeletion(articleId) {
      if (confirm(sureToDeleteMessage)) {
          // Отправляем DELETE запрос через fetch
          fetch('/profile/delete', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/x-www-form-urlencoded',
              },
              body: 'id=' + articleId
          })
          .then(response => response.json())
          .then(data => {
              if (data.success) {
                  alert("<?php echo addslashes($data['translations']['artsuccessdelete']); ?>");
                  window.location.reload();
              } else {
                  alert("<?php echo addslashes($data['translations']['arterrordelete']); ?>");
              }
          })
          .catch(error => {
              alert("<?php echo addslashes($data['translations']['error']); ?>");
              console.error(error);
          });
      }
  }
</script>
