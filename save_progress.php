<?php
include 'db.php';
if (!isset($_SESSION['user_id'])) exit;
$book_id = $_POST['book_id'];
$progress = (int)$_POST['progress'];
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("INSERT INTO user_progress (user_id, book_id, progress_seconds) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE progress_seconds = ?");
$stmt->execute([$user_id, $book_id, $progress, $progress]);
?>
