<?php
require_once 'config.php';
requireRole('receiver');

$user_id = $_SESSION['user_id'];
$name = htmlspecialchars($_SESSION['name']);

// Handle marking as collected
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'mark_collected') {
    $claim_id = intval($_POST['claim_id'] ?? 0);
    // Ensure the claim belongs to user
    $stmt = $pdo->prepare("SELECT post_id FROM claims WHERE id = ? AND receiver_id = ?");
    $stmt->execute([$claim_id, $user_id]);
    if ($claim_row = $stmt->fetch()) {
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare("UPDATE claims SET status = 'completed' WHERE id = ?");
            $stmt->execute([$claim_id]);
            $stmt = $pdo->prepare("UPDATE food_posts SET status = 'completed' WHERE id = ?");
            $stmt->execute([$claim_row['post_id']]);
            $pdo->commit();
        } catch (Exception $e) {
            $pdo->rollBack();
        }
    }
    header("Location: receiver_dashboard.php");
    exit;
}

// Stats
$stmt = $pdo->prepare("SELECT COUNT(*) FROM claims WHERE receiver_id = ?");
$stmt->execute([$user_id]);
$total_claims = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM claims WHERE receiver_id = ? AND status = 'pending'");
$stmt->execute([$user_id]);
$pending_claims = $stmt->fetchColumn();

// Join to get image_url as well
$stmt = $pdo->prepare("SELECT c.*, f.title, f.quantity, f.location, f.expiry_time, f.image_url, u.name as donor_name 
    FROM claims c 
    JOIN food_posts f ON c.post_id = f.id 
    JOIN users u ON f.donor_id = u.id 
    WHERE c.receiver_id = ? 
    ORDER BY c.claimed_at DESC LIMIT 10");
$stmt->execute([$user_id]);
$claims = $stmt->fetchAll();
$page_title = 'FoodShare | Receiver Dashboard';
require_once 'includes/header.php';
?>
<!-- Main Content Canvas -->
<main class="pt-32 pb-20 px-4 md:px-8 max-w-7xl mx-auto w-full flex-grow">
<!-- Hero Stats Section: Bento Style -->
<header class="mb-12">
<h1 class="text-5xl font-black font-headline tracking-tighter text-on-surface mb-2">Receiver Dashboard</h1>
<p class="text-on-surface-variant max-w-2xl text-lg">Managing your impact. Every claimed item is a step towards zero waste and a healthier community.</p>
</header>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
<!-- Stats Card 1 -->
<div class="bg-primary-container/10 p-8 rounded-xl flex flex-col justify-between relative overflow-hidden group">
<div class="relative z-10">
<span class="text-sm font-bold uppercase tracking-widest text-primary mb-2 block font-label">Total Impact</span>
<div class="text-6xl font-black font-headline text-on-primary-container"><?php echo $total_claims; ?></div>
<p class="mt-4 text-on-surface-variant font-medium">Items successfully claimed and redistributed through your account.</p>
</div>
<span class="material-symbols-outlined absolute -bottom-4 -right-4 text-primary/10 text-9xl group-hover:scale-110 transition-transform">restaurant</span>
</div>
<!-- Stats Card 2 -->
<div class="bg-tertiary-container/10 p-8 rounded-xl flex flex-col justify-between relative overflow-hidden group">
<div class="relative z-10">
<span class="text-sm font-bold uppercase tracking-widest text-tertiary mb-2 block font-label">Active Requests</span>
<div class="text-6xl font-black font-headline text-on-tertiary-container"><?php echo sprintf("%02d", $pending_claims); ?></div>
<p class="mt-4 text-on-surface-variant font-medium">Pending pickups or approvals currently in your active queue.</p>
</div>
<span class="material-symbols-outlined absolute -bottom-4 -right-4 text-tertiary/10 text-9xl group-hover:scale-110 transition-transform">pending_actions</span>
</div>
<!-- Stats Card 3 -->
<div class="bg-surface-container-highest p-8 rounded-xl flex flex-col justify-between relative overflow-hidden">
<div class="relative z-10">
<span class="text-sm font-bold uppercase tracking-widest text-on-surface-variant mb-2 block font-label">Waste Diverted</span>
<div class="text-4xl font-black font-headline text-on-surface"><?php echo $total_claims * 2.5; ?><span class="text-xl font-bold ml-1">kg</span></div>
<p class="mt-4 text-on-surface-variant font-medium">Estimated weight of food redirected from landfills to community plates.</p>
</div>
<div class="mt-6 flex gap-2">
<div class="h-2 flex-grow bg-surface-container-low rounded-full overflow-hidden">
<div class="h-full bg-primary w-3/4 rounded-full"></div>
</div>
<span class="text-xs font-bold font-label">75% of Goal</span>
</div>
</div>
</div>
<!-- Claims Section -->
<section class="mb-12">
<div class="flex justify-between items-end mb-8">
<div>
<h2 class="text-3xl font-black font-headline tracking-tight text-on-surface">Your Claim History</h2>
<p class="text-on-surface-variant">Track the status of your recent surplus food acquisitions.</p>
</div>
        <div class="flex gap-2">
            <a href="feed.php" class="px-4 py-2 text-sm font-bold bg-primary rounded-lg text-on-primary hover:bg-primary/90 transition-colors shadow-sm">Find Food</a>
        </div>
    </div>
<div class="space-y-4">
<?php if(empty($claims)): ?>
    <div class="bg-surface-container-lowest p-6 rounded-xl editorial-shadow text-center">
        <p class="text-on-surface-variant italic">No claims yet. Visit the feed to find food.</p>
    </div>
<?php else: ?>
    <?php foreach($claims as $claim): ?>
        <?php 
            $img_src = !empty($claim['image_url']) ? htmlspecialchars($claim['image_url']) : 'https://lh3.googleusercontent.com/aida-public/AB6AXuCQg6QwBWb67ZUSx9_Af1m4uU8suG4LQIJPWckx8UtbfHb5Zv6cyc7puv1JKNNATqAGzTkHUAI1OixqwdQfRwSwKXmnH8LPrig0NaBfDt7c9Ozk5YlEXE2tnXF_rZ1T0jxiMFPbesYjI2Hmzh8M8pskKhrrSovFo5x1I1y_vdIhpG1nyhFCkRYo-k8-Rrr2WjE_FOWet89qkrrK415H9LRPKsYyKP0CRsjtstiWXo-SbMI_fHu_s5PMIaHXIB4ZU5FW7gQAM_pN02U';
            $is_completed = $claim['status'] === 'completed';
        ?>
        <div class="bg-surface-container-lowest p-6 rounded-xl editorial-shadow flex flex-col md:flex-row gap-6 items-center group <?php echo $is_completed ? 'opacity-80 hover:opacity-100 transition-opacity' : 'hover:bg-surface transition-colors'; ?>">
        <div class="w-full md:w-48 h-32 rounded-lg overflow-hidden flex-shrink-0 <?php echo $is_completed ? 'grayscale group-hover:grayscale-0 transition-all duration-500' : ''; ?>">
        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="<?php echo $img_src; ?>"/>
        </div>
        <div class="flex-grow w-full">
        <div class="flex justify-between items-start mb-2">
        <div>
        <h3 class="text-xl font-extrabold font-headline text-on-surface"><?php echo htmlspecialchars($claim['title']); ?></h3>
        <p class="text-on-surface-variant text-sm flex items-center gap-1 mt-1">
        <span class="material-symbols-outlined text-sm">location_on</span>
                                            <?php echo htmlspecialchars($claim['donor_name']); ?> • <?php echo htmlspecialchars($claim['location']); ?>
                                        </p>
        </div>
        <?php if($is_completed): ?>
            <span class="px-3 py-1 rounded-full bg-secondary-container text-on-secondary-container font-bold text-xs font-label tracking-wider uppercase">Completed</span>
        <?php else: ?>
            <span class="px-3 py-1 rounded-full bg-tertiary-container text-on-tertiary-container font-bold text-xs font-label tracking-wider uppercase">Pending</span>
        <?php endif; ?>
        </div>
        <div class="flex gap-6 mt-4">
        <div>
        <span class="block text-[10px] uppercase font-bold text-on-surface-variant tracking-widest font-label mb-1">Claimed On</span>
        <span class="text-sm font-bold"><?php echo date('M d, g:i A', strtotime($claim['claimed_at'])); ?></span>
        </div>
        <div>
        <span class="block text-[10px] uppercase font-bold text-on-surface-variant tracking-widest font-label mb-1">Quantity/Info</span>
        <span class="text-sm font-bold text-primary"><?php echo htmlspecialchars($claim['quantity']); ?></span>
        </div>
        <?php if(!$is_completed): ?>
            <div>
            <span class="block text-[10px] uppercase font-bold text-on-surface-variant tracking-widest font-label mb-1">Pick up before</span>
            <span class="text-sm font-bold text-tertiary"><?php echo date('M d, g:i A', strtotime($claim['expiry_time'])); ?></span>
            </div>
        <?php endif; ?>
        </div>
        </div>
        <div class="flex flex-row md:flex-col gap-2 w-full md:w-auto">
        <?php if(!$is_completed): ?>
            <form method="POST" class="m-0 w-full md:w-auto flex flex-col gap-2">
                <input type="hidden" name="action" value="mark_collected">
                <input type="hidden" name="claim_id" value="<?php echo $claim['id']; ?>">
                <button type="submit" class="flex-grow md:flex-none w-full px-6 py-3 bg-primary text-on-primary font-bold rounded-lg text-sm transition-all active:scale-95 whitespace-nowrap">Mark Collected</button>
            </form>
        <?php endif; ?>
        </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
</div>
</section>
<!-- Informational Section -->
<section class="grid grid-cols-1 md:grid-cols-2 gap-8">
<div class="bg-zinc-900 text-zinc-100 p-10 rounded-2xl relative overflow-hidden">
<div class="relative z-10">
<h4 class="text-2xl font-black font-headline mb-4">Receiver Guidelines</h4>
<ul class="space-y-4">
<li class="flex items-start gap-3">
<span class="material-symbols-outlined text-emerald-400">check_circle</span>
<span class="text-zinc-400">Arrive within the specified window to ensure food freshness.</span>
</li>
<li class="flex items-start gap-3">
<span class="material-symbols-outlined text-emerald-400">check_circle</span>
<span class="text-zinc-400">Bring your own reusable bags or containers when possible.</span>
</li>
<li class="flex items-start gap-3">
<span class="material-symbols-outlined text-emerald-400">check_circle</span>
<span class="text-zinc-400">Confirm collection in-app to complete the transaction.</span>
</li>
</ul>
</div>
<div class="absolute top-0 right-0 p-8 opacity-20">
<span class="material-symbols-outlined text-9xl">menu_book</span>
</div>
</div>
<div class="bg-surface-container-low p-10 rounded-2xl flex flex-col justify-center border border-outline/5">
<h4 class="text-2xl font-black font-headline mb-4">Need Assistance?</h4>
<p class="text-on-surface-variant mb-6">If you're having trouble with a pickup or need to contact a donor, our support team is available 24/7 to facilitate the redistribution process.</p>
<a href="mailto:support@foodshare.local" class="w-fit px-8 py-3 bg-white text-on-surface font-bold rounded-lg editorial-shadow hover:bg-surface-container-highest transition-all">Contact Support</a>
</div>
</section>
</main>
<?php require_once 'includes/footer.php'; ?>
