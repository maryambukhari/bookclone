<?php
include 'db.php';
if (!isset($_SESSION['user_id'])) { echo "<script>window.location.href='login.php';</script>"; }
$book_id = $_GET['book_id'];
$bookStmt = $pdo->prepare("SELECT * FROM audiobooks WHERE id = ?");
$bookStmt->execute([$book_id]);
$book = $bookStmt->fetch();

$progressStmt = $pdo->prepare("SELECT progress_seconds FROM user_progress WHERE user_id = ? AND book_id = ?");
$progressStmt->execute([$_SESSION['user_id'], $book_id]);
$progress = $progressStmt->fetchColumn() ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Player - <?= $book['title'] ?></title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #1e3c72, #2a5298); color: #fff; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .player { background: rgba(0,0,0,0.5); padding: 20px; border-radius: 15px; width: 80%; max-width: 600px; box-shadow: 0 10px 20px rgba(0,0,0,0.3); }
        audio { width: 100%; }
        button { background: #ff9900; margin: 5px; padding: 10px; border: none; border-radius: 5px; }
        select { background: #fff; color: #000; padding: 10px; }
    </style>
</head>
<body>
    <div class="player">
        <img src="<?= $book['cover_image'] ?>" alt="" style="width:100%; border-radius:10px;">
        <h2><?= $book['title'] ?> by <?= $book['author'] ?></h2>
        <audio id="audio" src="<?= $book['audio_url'] ?>" controls></audio>
        <div>
            <button onclick="playPause()">Play/Pause</button>
            <button onclick="rewind()">Rewind 10s</button>
            <button onclick="forward()">Forward 10s</button>
            <select id="speed" onchange="changeSpeed()">
                <option value="1">1x</option>
                <option value="1.5">1.5x</option>
                <option value="2">2x</option>
            </select>
        </div>
    </div>
    <script>
        const audio = document.getElementById('audio');
        audio.currentTime = <?= $progress ?>;
        function playPause() { audio.paused ? audio.play() : audio.pause(); }
        function rewind() { audio.currentTime -= 10; }
        function forward() { audio.currentTime += 10; }
        function changeSpeed() { audio.playbackRate = document.getElementById('speed').value; }
        
        // Save progress every 10s and on unload
        setInterval(saveProgress, 10000);
        window.onunload = saveProgress;
        function saveProgress() {
            fetch('save_progress.php', {
                method: 'POST',
                body: new URLSearchParams({book_id: <?= $book_id ?>, progress: audio.currentTime})
            });
        }
        // Resume
        audio.addEventListener('loadedmetadata', () => { audio.currentTime = <?= $progress ?>; });
    </script>
</body>
</html>
