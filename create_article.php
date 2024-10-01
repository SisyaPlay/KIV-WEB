<?php
session_start();
global $connect;

if (!isset($_SESSION['user_id'])) {
    header("location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Project-m Blog</title>
    <link rel="stylesheet" href="assets/css/main.css">
<!--    <script src="assets/ckeditor/ckeditor.js"></script>-->
    <script src="//cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
</head>
<body>
<div class="background"></div>
<!-- Заголовок -->

<label class="main-label">Project-M</label>
<header>
    <div class="left-buttons">
        <button class="button" onclick="location.href='index.php'">Home</button>
        <button class="button">Album</button>
    </div>

    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="dropdown-profile">
            <button class="profileBtn" id="profileBtn"></button>
            <div class="dropdown-profile-content" id="profileDropdown">
                <form id="profileForm">
                    <div class="profilePic"></div>
                    <div>Change your profile picture</div>
                    <input type="file" id="myFile" name="filename">
                    <button class="button" id="changePass">Change password</button>
                    <button class="button" type="button" id="logoutBtn">Logout</button>
                </form>
            </div>
        </div>
    <?php endif; ?>
</header>

<form class="main-container" action="vendor/post_article.php" method="post" enctype="multipart/form-data">
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

<script src="assets/js/main.js"></script>
<script src="assets/js/profile.js"></script>
</body>
<script>
    CKEDITOR.replace( 'content' );
</script>
</html>
