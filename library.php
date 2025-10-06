<?php
include 'db.php';
if (!isset($_SESSION['user_id'])) { echo "<script>window.location.href='login.php';</script>"; }
$booksStmt = $pdo->query("SELECT a.*, c.name AS category FROM audiobooks a LEFT JOIN categories c ON a.category_id = c.id");
$books = $booksStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library</title>
    <style>
        /* Reuse home CSS */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #1e3c72, #2a5298); color: #fff; margin: 0; }
        .container { max-width: 1200px; margin: 20px auto; }
        .books-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; }
        .book { background: #fff; color: #000; border-radius: 15px; padding: 10px; box-shadow: 0 10px 20px rgba(0,0,0,0.2); }
        img { width: 100%; height: 150px; object-fit: cover; border-radius: 10px; }
        button { background: #ff9900; }
        @media (max-width: 768px) { .books-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class="container">
        <h2>Audiobook Library</h2>
        <div class="books-grid">
            <?php foreach ($books as $book): ?>
                <div class="book">
                    <img src="<?= $book['cover_image'] ?>" alt="<?= $book['title'] ?>">
                    <h3><?= $book['title'] ?></h3>
                    <p><?= $book['author'] ?> - <?= $book['category'] ?></p>
                    <button onclick="saveBook(<?= $book['id'] ?>)">Save</button>
                    <button onclick="window.location.href='player.php?book_id=<?= $book['id'] ?>'">Play</button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script>
        function saveBook(bookId) {
            fetch('save_book.php', { method: 'POST', body: new URLSearchParams({book_id: bookId}) })
                .then(() => alert('Saved!'));
        }
    </script>
</body>
</html>
