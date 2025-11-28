<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photo'])) {
    $file = $_FILES['photo'];
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (in_array($ext, $allowed)) {
        // Create unique filename to prevent overwrites
        $newName = uniqid() . '.' . $ext;
        $destination = 'uploads/' . $newName;

        if (!is_dir('uploads')) mkdir('uploads');

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            // Save to DB
            $stmt = $pdo->prepare("INSERT INTO photos (user_id, filename) VALUES (?, ?)");
            $stmt->execute([$_SESSION['user_id'], $newName]);
            header("Location: gallery.php");
        } else {
            echo "Failed to move file.";
        }
    } else {
        echo "Invalid file type.";
    }
}
?>
