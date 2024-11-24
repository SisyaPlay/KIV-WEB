<script src="//cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<div class="main-container">
  <form action="/create_article" method="post" enctype="multipart/form-data">
      <label for="title">Title</label>
      <div class="input-wrapper">
          <input type="text" name="title" id="title" placeholder="Type a title of an article" required>
          <span class="error-message" id="title-error"></span>
      </div>

      <label for="content">Text</label>
      <textarea name="content" id="content"></textarea>

      <label for="media">Upload a video or picture</label>
      <input type="file" name="media[]" accept="image/*,video/*,.gif" multiple>

      <button type="submit">Create an article</button>
  </form>
</div>

<?php
if(@$_SESSION['registered']) {
    echo '<p class="registeredMessage">' . $_SESSION['registered']. '</p>';
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
if(@$_SESSION['massage']) {
    echo '<p class="msg">' . $_SESSION['massage']. '</p>';
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

<script src="application/assets/js/main.js"></script>
<script src="application/assets/js/login.js"></script>
<script>
    CKEDITOR.replace('content');
</script>
