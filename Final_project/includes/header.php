<?php
// includes/header.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$is_logged_in = isset($_SESSION['user_id']);
$role = $is_logged_in ? $_SESSION['role'] : null;
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title><?php echo $page_title ?? 'FoodShare - The Living Archive of Freshness'; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="assets/js/tailwind-config.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-surface font-body text-on-surface flex flex-col min-h-screen">
<!-- TopNavBar (Shared) -->
<nav class="fixed top-0 w-full z-50 bg-white/80 dark:bg-zinc-950/80 backdrop-blur-md shadow-[0_8px_32px_rgba(44,62,80,0.04)] h-20">
    <div class="flex justify-between items-center px-8 h-full max-w-full mx-auto">
        <a href="index.php" class="text-2xl font-black tracking-tighter text-emerald-700 dark:text-emerald-500 font-headline hover:opacity-80 transition-opacity">FoodShare</a>
        
        <div class="hidden md:flex items-center gap-8">
            <a class="font-headline font-bold tracking-tight <?php echo $current_page == 'index.php' ? 'text-emerald-700 border-b-2 border-emerald-600 pb-1' : 'text-zinc-600 hover:text-emerald-600 transition-colors'; ?>" href="index.php">Home</a>
            
            <a class="font-headline font-bold tracking-tight <?php echo $current_page == 'feed.php' ? 'text-emerald-700 border-b-2 border-emerald-600 pb-1' : 'text-zinc-600 hover:text-emerald-600 transition-colors'; ?>" href="feed.php">View Food</a>
            
            <?php if ($role === 'donor'): ?>
            <a class="font-headline font-bold tracking-tight <?php echo $current_page == 'post_food.php' ? 'text-emerald-700 border-b-2 border-emerald-600 pb-1' : 'text-zinc-600 hover:text-emerald-600 transition-colors'; ?>" href="post_food.php">Post Food</a>
            <?php endif; ?>
            
            <?php if ($is_logged_in): ?>
            <a class="font-headline font-bold tracking-tight <?php echo (in_array($current_page, ['dashboard.php', 'donor_dashboard.php', 'receiver_dashboard.php'])) ? 'text-emerald-700 border-b-2 border-emerald-600 pb-1' : 'text-zinc-600 hover:text-emerald-600 transition-colors'; ?>" href="dashboard.php">Dashboard</a>
            <?php endif; ?>
        </div>
        
        <div class="flex items-center gap-4">
            <?php if ($is_logged_in): ?>
                <button class="flex items-center justify-center rounded-full p-2 bg-surface-container-high text-on-surface hover:bg-surface-container-highest transition-all">
                    <span class="material-symbols-outlined">notifications</span>
                </button>
                <div class="group relative">
                    <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10 ring-2 ring-primary/20 cursor-pointer" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuDUybnWh0pMJr6yH_0fq-tk9vzK97_il3FfEkSQjgFMSeHkW-Vgggp2HwpoM22LbVmll001jMHkg4MRHBDzA46BUxYai8kAAxNUvG8O_4EUVwFp90qBqXMiEKPxVQH0WaGqd9dBkb94kmx4eWLuNLkhPylZGcPTVrnoM6Jxq-AAl42rn36zwJ-VTx8yvDe_bmIHPfUfSWr8dEj943cWu7UR_fp6sZu74eVRKP3NsTqvoGc6eE6Wk8_3p5dCgTD5GfccozkVY9nHaT0");'></div>
                    <div class="absolute right-0 mt-2 w-48 bg-white dark:bg-zinc-900 rounded-xl shadow-lg border border-outline-variant/20 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                        <a href="dashboard.php" class="block px-4 py-3 text-sm text-on-surface hover:bg-surface-container-high font-bold first:rounded-t-xl transition-colors">Dashboard</a>
                        <a href="logout.php" class="block px-4 py-3 text-sm text-red-600 hover:bg-red-50 font-bold last:rounded-b-xl transition-colors">Logout</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="auth.php" class="px-6 py-2.5 rounded-xl font-headline font-bold text-on-primary bg-primary hover:bg-primary/90 transition-all duration-200 active:scale-95 text-center inline-block">Login</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
