<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); // Start session globally if needed

$host = 'localhost'; // Change this to your actual DB host (e.g., 'mysql.yourhost.com' or IP from control panel)
$dbname = 'dblzxznfdayimq';
$username = 'uasxxqbztmxwm';
$password = 'wss863wqyhal';

$pdo = null;
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Echo error for display (if display_errors is on) and log it
    echo "Connection failed: " . $e->getMessage();
    error_log("DB Connection Error: " . $e->getMessage(), 0); // Logs to server error log
    $pdo = null; // Set to null to prevent further queries
}
?>
