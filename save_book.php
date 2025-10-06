<?php
include 'db.php';
if (!isset($_SESSION['user_id'])) exit;
$book_id = $_POST['book_id'];
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("INSERT IGNORE INTO saved_books (user_id, book_id) VALUES (?, ?)");
$stmt->execute([$user_id, $book_id]);
?>
