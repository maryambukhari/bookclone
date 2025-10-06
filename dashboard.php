<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db.php';
if (!isset($_SESSION['user_id'])) { echo "<script>window.location.href='login.php';</script>"; exit; }
$user_id = $_SESSION['user_id'];
$saved = [];
if ($pdo) {
    try {
        $savedStmt = $pdo->prepare("SELECT a.*, COALESCE(up.progress_seconds, 0) AS progress_seconds FROM saved_books sb JOIN audiobooks a ON sb.book_id = a.id LEFT JOIN user_progress up ON up.book_id = a.id AND up.user_id = ? WHERE sb.user_id = ?");
        $savedStmt->execute([$user_id, $user_id]);
        $saved = $savedStmt->fetchAll();
    } catch (PDOException $e) {
        echo "Dashboard load error: " . $e->getMessage();
    }
} else {
    echo "<p>Database connection issue - cannot load dashboard.</p>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #1e3c72, #2a5298); color: #fff; margin: 0; }
        .container { max-width: 1200px; margin: 20px auto; }
        .saved { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; }
        .progress-bar { background: #333; height: 10px; border-radius: 5px; }
        .progress-fill { background: #ff9900; height: 100%; width: 0%; transition: width 0.3s; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Your Dashboard</h2>
        <div class="saved">
            <?php foreach ($saved as $book): 
                $progress_seconds = (int)$book['progress_seconds'];
                $percent = $progress_seconds > 0 ? min(($progress_seconds / 3600) * 100, 100) : 0; // Assume 1hr avg, cap at 100%
            ?>
                <div>
                    <img src="<?= htmlspecialchars($book['cover_image']) ?>" alt="" style="width:100%;">
                    <h3><?= htmlspecialchars($book['title']) ?></h3>
                    <p>Progress: <?= $progress_seconds ?>s</p>
                    <div class="progress-bar"><div class="progress-fill" style="width: <?= $percent ?>%;"></div></div>
                    <button onclick="window.location.href='player.php?book_id=<?= $book['id'] ?>'">Resume</button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script>
        // Update progress bars dynamically if needed
    </script>
</body>
</html>
