<?php
session_start();
require 'db.php';

// Security Check: Kick user out if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Fetch user's photos from database
$stmt = $pdo->prepare("SELECT * FROM photos WHERE user_id = ? ORDER BY uploaded_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$photos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Gallery</title>
    <!-- Corrected HTTPS links for styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-100 min-h-screen">

    <!-- Navbar -->
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-camera-retro text-2xl text-indigo-600"></i>
                    <span class="font-bold text-xl tracking-tight text-slate-800">PhotoVault</span>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-slate-600 text-sm font-medium">
                        Hi, <?php echo htmlspecialchars($_SESSION['username']); ?>
                    </span>
                    <a href="logout.php" class="text-slate-500 hover:text-red-600 transition-colors">
                        <i class="fa-solid fa-right-from-bracket text-lg"></i>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto p-6">
        
        <!-- Upload Section -->
        <div class="mb-10">
            <form action="upload.php" method="POST" enctype="multipart/form-data">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 text-center relative overflow-hidden group hover:border-indigo-400 transition-colors cursor-pointer">
                    <input type="file" name="photo" required class="absolute inset-0 opacity-0 cursor-pointer z-10 w-full h-full" onchange="this.form.submit()">
                    <div class="pointer-events-none">
                        <div class="w-16 h-16 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-cloud-arrow-up text-2xl text-indigo-600"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-slate-800">Upload Photo</h3>
                        <p class="text-slate-500 text-sm mt-1">Click to select and upload instantly</p>
                    </div>
                </div>
            </form>
        </div>

        <!-- Gallery Header -->
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-slate-800">My Gallery</h2>
            <span class="bg-slate-200 text-slate-600 text-xs font-bold px-2 py-1 rounded-full">
                <?php echo count($photos); ?> photos
            </span>
        </div>

        <?php if (count($photos) === 0): ?>
            <!-- Empty State (No photos) -->
            <div class="text-center py-20">
                <div class="inline-block p-4 rounded-full bg-slate-100 mb-4">
                    <i class="fa-regular fa-images text-4xl text-slate-400"></i>
                </div>
                <p class="text-slate-500">No photos yet. Upload your first one!</p>
            </div>
        <?php else: ?>
            <!-- Photo Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php foreach($photos as $photo): ?>
                    <div class="group relative aspect-square bg-slate-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all">
                        <!-- The Image -->
                        <img src="uploads/<?php echo htmlspecialchars($photo['filename']); ?>" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                             loading="lazy">
                        
                        <!-- The Overlay (Delete & Download Buttons) -->
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-3">
                            
                            <!-- Delete Button -->
                            <a href="delete.php?id=<?php echo $photo['id']; ?>" 
                               onclick="return confirm('Are you sure you want to delete this photo?');"
                               class="bg-white/90 hover:bg-red-500 hover:text-white text-red-500 w-10 h-10 flex items-center justify-center rounded-full shadow-lg transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                                <i class="fa-solid fa-trash"></i>
                            </a>

                            <!-- Download Button -->
                            <a href="uploads/<?php echo htmlspecialchars($photo['filename']); ?>" download 
                               class="bg-white/90 hover:bg-indigo-500 hover:text-white text-indigo-500 w-10 h-10 flex items-center justify-center rounded-full shadow-lg transform translate-y-4 group-hover:translate-y-0 transition-all duration-300 delay-75">
                                <i class="fa-solid fa-download"></i>
                            </a>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </main>
</body>
</html>
