<?php
$host = 'sql111.infinityfree.com';
$dbname = 'if0_40246602_city_events';
$username = 'if0_40246602';
$password = 'BbDdXxCc1234';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Admin authentication function
function authenticateAdmin($username, $password, $pdo) {
    $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch();
    
    if ($admin && $password == $admin['password']) {
        return $admin;
    }
    return false;
}

// Check if admin is logged in
function isAdminLoggedIn() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

// Require admin authentication
function requireAdminAuth() {
    if (!isAdminLoggedIn()) {
        header('Location: login.php');
        exit();
    }
}
?>