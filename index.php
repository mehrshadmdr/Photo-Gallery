<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhotoVault - Login</title>
    <!-- ✅ CORRECT: With https:// -->
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen p-4">

    <div class="bg-white w-full max-w-md p-8 rounded-2xl shadow-xl border border-slate-200">
        <div class="text-center mb-8">
            <i class="fa-solid fa-camera-retro text-4xl text-indigo-600 mb-2"></i>
            <h1 class="text-2xl font-bold text-slate-800">PhotoVault</h1>
            <p class="text-slate-500 text-sm">Secure Personal Gallery</p>
        </div>

        <!-- Notification Area -->
        <?php if (isset($_GET['error'])): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-4 text-sm">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['msg'])): ?>
            <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-3 mb-4 text-sm">
                <?php echo htmlspecialchars($_GET['msg']); ?>
            </div>
        <?php endif; ?>

        <!-- Forms Container -->
        <div id="forms-container">
            
            <!-- Login Form -->
            <form id="login-form" action="login.php" method="POST" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Username</label>
                    <input type="text" name="username" required class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                    <input type="password" name="password" required class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-lg transition-colors shadow-md">
                    Sign In
                </button>
                <p class="text-center text-sm text-slate-600 mt-4">
                    New here? <button type="button" onclick="toggleAuth()" class="text-indigo-600 hover:underline">Create account</button>
                </p>
            </form>

            <!-- Register Form (Hidden by default) -->
            <form id="register-form" action="register.php" method="POST" class="space-y-4 hidden">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Choose Username</label>
                    <input type="text" name="username" required class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Choose Password</label>
                    <input type="password" name="password" required class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2.5 rounded-lg transition-colors shadow-md">
                    Create Account
                </button>
                <p class="text-center text-sm text-slate-600 mt-4">
                    Already have an account? <button type="button" onclick="toggleAuth()" class="text-indigo-600 hover:underline">Login</button>
                </p>
            </form>

        </div>
    </div>

    <script>
        function toggleAuth() {
            document.getElementById('login-form').classList.toggle('hidden');
            document.getElementById('register-form').classList.toggle('hidden');
        }
    </script>
</body>
</html>
