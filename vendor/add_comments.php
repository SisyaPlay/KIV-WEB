<?php
session_start();
global $connect;
require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $articleId = $_POST['article_id'];
    $userId = $_SESSION['user_id'];
    $content = trim($_POST['content']);
    $parentId = !empty($_POST['parent_id']) ? $_POST['parent_id'] : null;

    if (!empty($content)) {
        $stmt = $connect->prepare("INSERT INTO comments (article_id, user_id, parent_id, content, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("iiis", $articleId, $userId, $parentId, $content);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: ../articles_detail.php?id=" . $articleId);
    exit();
}
?>
