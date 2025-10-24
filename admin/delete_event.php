<?php
session_start();
require_once '../db.php';
requireAdminAuth();

session_start();
require_once '../db.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: dashboard.php');
    exit();
}

$event_id = $_GET['id'];

// Delete event
$stmt = $pdo->prepare("DELETE FROM events WHERE id = ?");
if ($stmt->execute([$event_id])) {
    header('Location: dashboard.php?success=1');
} else {
    header('Location: dashboard.php?error=1');
}
exit();
?>