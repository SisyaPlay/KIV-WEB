<?php
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header('location: index.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Project-m Blog</title>
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>
    <div class="background"></div>
    <!--  Заголовок -->

    <header>
        <div class="left-buttons">
            <button onclick="location.href='index.php'">Home</button>
            <button>Album</button>
        </div>
        <label class="center-label">Project-M</label>
        <div class="right-buttons">
            <?php if (isset($_SESSION['user_id'])): ?>
                <button id="logoutBtn">Logout</button>
            <?php else: ?>
            <?php endif; ?>
        </div>
    </header>

    <div class="main-container">
        <label class="center-label">Profile</label>
        <div class="profilePic"></div>
    </div>
    <script src="assets/js/main.js"></script>
</body>
</html>