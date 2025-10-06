<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $password]);
        echo "<script>alert('Signup success'); window.location.href='login.php';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #1e3c72, #2a5298); color: #fff; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        form { background: rgba(255,255,255,0.1); padding: 30px; border-radius: 15px; box-shadow: 0 10px 20px rgba(0,0,0,0.3); width: 300px; }
        input { width: 100%; padding: 10px; margin: 10px 0; border: none; border-radius: 5px; }
        button { background: #ff9900; color: #fff; padding: 10px; width: 100%; border: none; border-radius: 5px; cursor: pointer; transition: background 0.3s; }
        button:hover { background: #e68a00; }
    </style>
</head>
<body>
    <form method="POST">
        <h2>Signup</h2>
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Signup</button>
    </form>
    <script>
        // JS for form validation if needed
    </script>
</body>
</html>
