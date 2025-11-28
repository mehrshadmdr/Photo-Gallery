<?php
session_start();
require 'db.php';

// 1. Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

if (isset($_GET['id'])) {
    $photo_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // 2. Verify the photo belongs to the current user (Security!)
    $stmt = $pdo->prepare("SELECT filename FROM photos WHERE id = ? AND user_id = ?");
    $stmt->execute([$photo_id, $user_id]);
    $photo = $stmt->fetch();

    if ($photo) {
        // 3. Delete file from the server folder
        $file_path = "uploads/" . $photo['filename'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        // 4. Delete record from database
        $del_stmt = $pdo->prepare("DELETE FROM photos WHERE id = ?");
        $del_stmt->execute([$photo_id]);
    }
}

// 5. Go back to gallery
header("Location: gallery.php");
exit;
?>
