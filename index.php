<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db.php';
// Fetch books and categories - with null check
$books = [];
$categories = [];
if ($pdo) {
    try {
        $booksStmt = $pdo->query("SELECT a.*, c.name AS category FROM audiobooks a LEFT JOIN categories c ON a.category_id = c.id");
        $books = $booksStmt->fetchAll(PDO::FETCH_ASSOC);
        $categoriesStmt = $pdo->query("SELECT * FROM categories");
        $categories = $categoriesStmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Query error: " . $e->getMessage();
    }
} else {
    echo "<p>Database connection issue - please check db.php config.</p>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audible Clone - Home</title>
    <style>
        /* Amazing CSS: Gradients, fonts, effects */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #1e3c72, #2a5298); color: #fff; margin: 0; padding: 0; }
        header { background: rgba(0,0,0,0.5); padding: 20px; text-align: center; box-shadow: 0 4px 10px rgba(0,0,0,0.3); }
        h1 { margin: 0; font-size: 2.5em; text-shadow: 2px 2px 4px rgba(0,0,0,0.5); }
        nav a { color: #fff; margin: 0 15px; text-decoration: none; transition: color 0.3s ease; }
        nav a:hover { color: #ff9900; transform: scale(1.1); }
        .container { max-width: 1200px; margin: 20px auto; padding: 20px; }
        .featured { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; }
        .book-card { background: #fff; color: #000; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 20px rgba(0,0,0,0.2); transition: transform 0.3s ease; }
        .book-card:hover { transform: translateY(-10px); }
        .book-card img { width: 100%; height: 200px; object-fit: cover; }
        .book-card h3 { padding: 10px; margin: 0; background: #ff9900; color: #fff; }
        .book-card p { padding: 10px; }
        button { background: #ff9900; color: #fff; border: none; padding: 10px; cursor: pointer; border-radius: 5px; transition: background 0.3s; }
        button:hover { background: #e68a00; }
        @media (max-width: 768px) { .featured { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <header>
        <h1>Audible Clone</h1>
        <nav>
            <a href="javascript:window.location.href='login.php'">Login</a>
            <a href="javascript:window.location.href='signup.php'">Signup</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="javascript:window.location.href='dashboard.php'">Dashboard</a>
                <a href="javascript:window.location.href='library.php'">Library</a>
                <a href="javascript:window.location.href='logout.php'">Logout</a>
            <?php endif; ?>
        </nav>
    </header>
    <div class="container">
        <h2>Featured Audiobooks</h2>
        <div class="featured">
            <?php foreach ($books as $book): ?>
                <div class="book-card">
                    <img src="<?= $book['cover_image'] ?>" alt="<?= $book['title'] ?>">
                    <h3><?= $book['title'] ?> by <?= $book['author'] ?></h3>
                    <p><?= $book['description'] ?> (<?= $book['category'] ?>)</p>
                    <button onclick="window.location.href='player.php?book_id=<?= $book['id'] ?>'">Play</button>
                </div>
            <?php endforeach; ?>
        </div>
        <h2>Categories</h2>
        <ul>
            <?php foreach ($categories as $cat): ?>
                <li style="background: #ff9900; display: inline-block; padding: 10px; margin: 5px; border-radius: 5px;"><?= $cat['name'] ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <script>
        // Internal JS for any interactions
        console.log('Home loaded');
    </script>
</body>
</html>
