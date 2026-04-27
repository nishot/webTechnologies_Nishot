<?php
require_once 'config.php';
requireRole('donor');

$user_id = $_SESSION['user_id'];
$name = htmlspecialchars($_SESSION['name']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $delete_id = $_POST['post_id'] ?? null;
    if ($delete_id) {
        $stmt = $pdo->prepare("DELETE FROM food_posts WHERE id = ? AND donor_id = ? AND status = 'available'");
        $stmt->execute([$delete_id, $user_id]);
        header("Location: donor_dashboard.php");
        exit;
    }
}

// Fetch stats
$stmt = $pdo->prepare("SELECT COUNT(*) FROM food_posts WHERE donor_id = ?");
$stmt->execute([$user_id]);
$total_donations = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM food_posts WHERE donor_id = ? AND status = 'claimed'");
$stmt->execute([$user_id]);
$claimed_donations = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM food_posts WHERE donor_id = ? AND status = 'available'");
$stmt->execute([$user_id]);
$pending_donations = $stmt->fetchColumn();

// Fetch recent posts
$stmt = $pdo->prepare("SELECT * FROM food_posts WHERE donor_id = ? ORDER BY created_at DESC LIMIT 10");
$stmt->execute([$user_id]);
$recent_posts = $stmt->fetchAll();
$page_title = 'FoodShare | Donor Dashboard';
require_once 'includes/header.php';
?>

    <main class="flex-1 mt-20 px-6 lg:px-40 py-12 max-w-[1200px] mx-auto w-full">
        <div class="mb-12">
            <h1 class="font-headline text-on-surface text-5xl font-extrabold tracking-tighter mb-2">Welcome, <?php echo $name; ?></h1>
            <p class="text-on-surface-variant font-medium text-lg italic">Your editorial of impact. Feeding the community, one share at a time.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <!-- Total Donations -->
            <div class="bg-surface-container-highest p-8 rounded-xl flex flex-col gap-2 relative overflow-hidden group">
                <div class="relative z-10">
                    <span class="text-sm font-bold uppercase tracking-widest text-on-surface-variant mb-2 block font-label">Total Donations</span>
                    <div class="text-5xl font-black font-headline text-on-surface"><?php echo $total_donations; ?></div>
                    <p class="mt-4 text-on-surface-variant text-sm font-medium">Overall impact recorded on the platform.</p>
                </div>
                <span class="material-symbols-outlined absolute -bottom-4 -right-4 text-on-surface/5 text-9xl group-hover:scale-110 transition-transform">inventory_2</span>
            </div>
            <!-- Claimed -->
            <div class="bg-primary-container/20 border border-primary/10 p-8 rounded-xl flex flex-col gap-2 relative overflow-hidden group">
                <div class="relative z-10">
                    <span class="text-sm font-bold uppercase tracking-widest text-primary mb-2 block font-label">Claimed</span>
                    <div class="text-5xl font-black font-headline text-on-primary-container"><?php echo $claimed_donations; ?></div>
                    <p class="mt-4 text-primary/80 text-sm font-medium">Surplus items successfully redistributed.</p>
                </div>
                <span class="material-symbols-outlined absolute -bottom-4 -right-4 text-primary/10 text-9xl group-hover:scale-110 transition-transform">check_circle</span>
            </div>
            <!-- Available -->
            <div class="bg-tertiary-container/20 border border-tertiary/10 p-8 rounded-xl flex flex-col gap-2 relative overflow-hidden group">
                <div class="relative z-10">
                    <span class="text-sm font-bold uppercase tracking-widest text-tertiary mb-2 block font-label">Available</span>
                    <div class="text-5xl font-black font-headline text-on-tertiary-container"><?php echo $pending_donations; ?></div>
                    <p class="mt-4 text-tertiary/80 text-sm font-medium">Active listings waiting to be matched.</p>
                </div>
                <span class="material-symbols-outlined absolute -bottom-4 -right-4 text-tertiary/10 text-9xl group-hover:scale-110 transition-transform">pending_actions</span>
            </div>
        </div>

        <div class="mb-16">
            <a href="post_food.php" class="w-full md:w-auto inline-flex items-center justify-center gap-3 px-10 py-5 bg-gradient-to-r from-primary to-primary-container text-white rounded-xl font-headline text-xl font-bold shadow-lg shadow-primary/10 hover:shadow-primary/20 transition-all active:scale-95">
                <span class="material-symbols-outlined">add_circle</span> Donate Food
            </a>
        </div>

        <section class="mb-20">
            <div class="flex items-baseline justify-between mb-8 border-b-2 border-surface-container-high pb-4">
                <h3 class="font-headline text-3xl font-bold tracking-tight">Recent Donations</h3>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <?php if(empty($recent_posts)): ?>
                    <p class="text-on-surface-variant italic">No donations yet. Click 'Donate Food' to start!</p>
                <?php else: ?>
                    <?php foreach($recent_posts as $post): ?>
                        <?php $img_src = !empty($post['image_url']) ? htmlspecialchars($post['image_url']) : 'https://lh3.googleusercontent.com/aida-public/AB6AXuCQg6QwBWb67ZUSx9_Af1m4uU8suG4LQIJPWckx8UtbfHb5Zv6cyc7puv1JKNNATqAGzTkHUAI1OixqwdQfRwSwKXmnH8LPrig0NaBfDt7c9Ozk5YlEXE2tnXF_rZ1T0jxiMFPbesYjI2Hmzh8M8pskKhrrSovFo5x1I1y_vdIhpG1nyhFCkRYo-k8-Rrr2WjE_FOWet89qkrrK415H9LRPKsYyKP0CRsjtstiWXo-SbMI_fHu_s5PMIaHXIB4ZU5FW7gQAM_pN02U'; ?>
                        <div class="bg-white rounded-xl border border-outline-variant/20 shadow-sm group overflow-hidden flex flex-col md:flex-row gap-6 p-4">
                            <div class="w-full md:w-48 h-48 flex-shrink-0 overflow-hidden rounded-lg">
                                <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" src="<?php echo $img_src; ?>"/>
                            </div>
                            <div class="flex flex-col justify-between flex-1 py-2">
                                <div>
                                    <div class="flex items-center gap-2 mb-3">
                                        <?php if($post['status'] === 'claimed'): ?>
                                            <span class="bg-secondary-container text-on-secondary-container px-3 py-1 rounded-full text-xs font-bold uppercase tracking-widest">Claimed</span>
                                        <?php elseif($post['status'] === 'completed'): ?>
                                            <span class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-widest">Completed</span>
                                        <?php else: ?>
                                            <span class="bg-tertiary-container text-on-tertiary-container px-3 py-1 rounded-full text-xs font-bold uppercase tracking-widest">Available</span>
                                            <span class="text-tertiary font-bold text-xs uppercase tracking-tighter">Expires in <?php echo timeUntil($post['expiry_time']); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <h4 class="font-headline text-2xl font-bold mb-2"><?php echo htmlspecialchars($post['title']); ?></h4>
                                    <p class="text-on-surface-variant line-clamp-2 text-sm">Qty: <?php echo htmlspecialchars($post['quantity']); ?> • Loc: <?php echo htmlspecialchars($post['location']); ?></p>
                                </div>
                                <div class="mt-4 flex items-center justify-between">
                                    <span class="text-xs text-on-surface-variant font-label italic">Donated <?php echo timeAgo($post['created_at']); ?></span>
                                    <?php if($post['status'] === 'available'): ?>
                                    <form method="POST" action="donor_dashboard.php" class="m-0 p-0" onsubmit="return confirm('Are you sure you want to delete this listing?');">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                                        <button type="submit" title="Delete Listing" class="text-red-500 hover:text-red-700 font-bold text-sm flex items-center gap-1 transition-colors px-3 py-1.5 rounded-lg hover:bg-red-50">
                                            <span class="material-symbols-outlined text-[16px]">delete</span> Delete
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <?php require_once 'includes/footer.php'; ?>
