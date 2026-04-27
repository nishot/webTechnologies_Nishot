<!-- Footer (Shared) -->
<footer class="bg-surface-container-low border-t border-outline-variant/20 mt-auto py-6 px-6 md:px-12 w-full">
    <div class="max-w-[1200px] mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="flex items-center gap-2 text-primary">
            <div class="size-5">
                <svg fill="none" viewbox="0 0 48 48" xmlns="http://www.w3.org/2000/svg"><path d="M6 6H42L36 24L42 42H6L12 24L6 6Z" fill="currentColor"></path></svg>
            </div>
            <span class="font-headline font-black text-on-surface">FoodShare</span>
        </div>
        <div class="text-xs text-on-surface-variant font-medium">
            © 2024 FoodShare Initiative. All rights reserved.
        </div>
    </div>
</footer>

<?php if (isset($is_logged_in) && $is_logged_in): ?>
<!-- Mobile Bottom Navigation -->
<nav class="md:hidden fixed bottom-0 left-0 w-full bg-surface-container-lowest/90 backdrop-blur-md shadow-[0_-4px_24px_rgba(0,0,0,0.05)] z-50 flex justify-around items-center h-16 px-4 border-t border-outline-variant/20 pb-safe">
    <a class="flex flex-col items-center gap-1 <?php echo $current_page == 'index.php' ? 'text-primary' : 'text-on-surface-variant hover:text-on-surface transition-colors'; ?>" href="index.php">
        <span class="material-symbols-outlined" style="<?php echo $current_page == 'index.php' ? "font-variation-settings: 'FILL' 1;" : ""; ?>">home</span>
        <span class="text-[10px] font-bold uppercase tracking-tighter text-center leading-none">Home</span>
    </a>
    <a class="flex flex-col items-center gap-1 <?php echo $current_page == 'feed.php' ? 'text-primary' : 'text-on-surface-variant hover:text-on-surface transition-colors'; ?>" href="feed.php">
        <span class="material-symbols-outlined" style="<?php echo $current_page == 'feed.php' ? "font-variation-settings: 'FILL' 1;" : ""; ?>">restaurant</span>
        <span class="text-[10px] font-bold uppercase tracking-tighter text-center leading-none">Feed</span>
    </a>
    <?php if (isset($role) && $role === 'donor'): ?>
    <a class="flex flex-col items-center gap-1 <?php echo $current_page == 'post_food.php' ? 'text-primary' : 'text-on-surface-variant hover:text-on-surface transition-colors'; ?>" href="post_food.php">
        <span class="material-symbols-outlined" style="<?php echo $current_page == 'post_food.php' ? "font-variation-settings: 'FILL' 1;" : ""; ?>">add_circle</span>
        <span class="text-[10px] font-bold uppercase tracking-tighter text-center leading-none">Post</span>
    </a>
    <?php endif; ?>
    <a class="flex flex-col items-center gap-1 <?php echo in_array($current_page, ['dashboard.php', 'donor_dashboard.php', 'receiver_dashboard.php']) ? 'text-primary' : 'text-on-surface-variant hover:text-on-surface transition-colors'; ?>" href="dashboard.php">
        <span class="material-symbols-outlined" style="<?php echo in_array($current_page, ['dashboard.php', 'donor_dashboard.php', 'receiver_dashboard.php']) ? "font-variation-settings: 'FILL' 1;" : ""; ?>">dashboard</span>
        <span class="text-[10px] font-bold uppercase tracking-tighter text-center leading-none">Dash</span>
    </a>
</nav>
<?php endif; ?>
</body>
</html>
