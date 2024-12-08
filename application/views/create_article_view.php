<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

<div class="main-container">
  <form class="full-width-form" action="/create_article" method="post" enctype="multipart/form-data">
      <label for="title"><?php echo htmlspecialchars($data['translations']['title']); ?></label>
      <div class="input-wrapper">
          <input type="text" name="title" id="title" placeholder="<?php echo htmlspecialchars($data['translations']['typeatitle']); ?>" required>
          <span class="error-message" id="title-error"></span>
      </div>

      <label for="content"><?php echo htmlspecialchars($data['translations']['text']); ?></label>
      <textarea id="summernote" name="editordata"></textarea>
      <label for="media"><?php echo htmlspecialchars($data['translations']['uploadvidpic']); ?></label>
      <input type="file" name="media[]" accept="image/*,video/*,.gif" multiple>

      <button type="submit"><?php echo htmlspecialchars($data['translations']['createart']); ?></button>
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

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

<script>
  $(document).ready(function () {
    const isMobile = window.matchMedia("(max-width: 992px)").matches;
    const mobileHeight = window.innerHeight - 1000;

    $("#summernote").summernote({
        height: isMobile ? mobileHeight : 362, // Высота редактора
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
        ]
    });
  });
 </script>
