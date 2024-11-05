<?php
    session_start();
    $user_id = $_SESSION['user_id'];
    global $connect;
    require_once 'vendor/connect.php';

    if (!isset($_SESSION['user_id'])) {
        header("location: main.php");
        exit();
    }
    // Получаем информацию о пользователе
    $query = $connect->prepare("SELECT * FROM users WHERE id = ?");
    $query->bind_param('i', $user_id);
    $query->execute();
    $result = $query->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $picture = $user['picture'];
    } else {
        echo "User not found.";
        exit();
    }
    include 'assets/php/navbar.php';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Project-m Blog</title>
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="//cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
</head>
<body>
    <form class="main-container" action="../vendor/post_article.php" method="post" enctype="multipart/form-data">
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

    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/login.js"></script>
    <script src="../assets/js/bootstrap.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../assets/js/fontawesome.js" crossorigin="anonymous"></script>
</body>
<script>
    CKEDITOR.replace( 'content' );
</script>
</html>
