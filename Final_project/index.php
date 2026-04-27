<?php
require_once 'config.php';

// Fetch 3 most recent available foods for the live feed sections
$stmt = $pdo->query("SELECT f.*, u.name as donor_name FROM food_posts f JOIN users u ON f.donor_id = u.id WHERE f.status = 'available' ORDER BY f.created_at DESC LIMIT 3");
$live_foods = $stmt->fetchAll();
$page_title = 'FoodShare - The Living Archive of Freshness';
require_once 'includes/header.php';
?>

<main class="pt-20 flex-grow">
<!-- Hero Section -->
<section class="relative min-h-[870px] flex items-center justify-center overflow-hidden px-6">
<div class="absolute inset-0 z-0">
<img class="w-full h-full object-cover opacity-15 grayscale" data-alt="top-down high-end professional food photography of fresh vibrant vegetables and rustic bread on a clean surface with soft natural daylight" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBhFWk7od2yBDGJdBeMbisezv38e9zS9cJjsIDF9mqagKUVX3k-LkLwv4LfUGQQIquQRGozanfhPOpD84xFo3hoRb2YH2r5ZtH4h1zOB4cZlXS4xJCgMicyf3_lQ2nokqvFJS2fIUmqP7SBVoZrxdlOcD2521EZZg_rht6WnoCXG6J1BjryikcGK-gLm1NR_6PdHIQ1gIH3UNtII4S9t5c9s3nhaACmNhdUKCIqMuO2tRtWaRlhBa5-dUIOUutyBHb0Q3Iznh78rCs"/>
<div class="absolute inset-0 bg-gradient-to-b from-surface/50 via-surface to-surface"></div>
</div>
<div class="relative z-10 max-w-4xl text-center">
<span class="inline-block mb-6 px-4 py-1.5 rounded-full bg-primary-container/20 text-primary font-label font-bold text-sm tracking-widest uppercase">
                    The Living Archive of Freshness
                </span>
<h1 class="font-headline text-5xl md:text-7xl font-extrabold tracking-tighter text-on-surface mb-8 leading-[1.1]">
                    Reduce Food Waste. <span class="text-primary">Share Food.</span>
</h1>
<p class="font-body text-xl md:text-2xl text-on-surface-variant mb-12 max-w-2xl mx-auto leading-relaxed">
                    Join our community in redirecting surplus food to those who need it. A premium editorial approach to food redistribution.
                </p>
<div class="flex flex-col sm:flex-row items-center justify-center gap-6">
<a href="auth.php" class="w-full sm:w-auto px-10 py-5 rounded-xl bg-gradient-to-r from-primary to-primary-container text-on-primary font-headline font-bold text-lg shadow-lg hover:shadow-primary/20 transition-all active:scale-95 text-center block">
                        Donate Food
                    </a>
<a href="feed.php" class="w-full sm:w-auto px-10 py-5 rounded-xl bg-surface-container-high text-on-surface font-headline font-bold text-lg hover:bg-surface-container-highest transition-all active:scale-95 text-center block">
                        Find Food
                    </a>
</div>
</div>
</section>
<!-- Features Section (Bento Grid Inspired) -->
<section class="py-24 px-8 bg-surface-container-low">
<div class="max-w-7xl mx-auto">
<div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-8">
<div class="max-w-2xl">
<h2 class="font-headline text-4xl font-extrabold tracking-tight mb-4">Our Vital Impact</h2>
<p class="text-on-surface-variant text-lg">Every surplus item is a headline waiting to be rewritten. We provide the tools to make sharing intuitive and elegant.</p>
</div>
<a href="feed.php" class="flex items-center gap-2 text-primary font-bold hover:underline">
<span>Explore the movement</span>
<span class="material-symbols-outlined">trending_flat</span>
</a>
</div>
<div class="grid grid-cols-1 md:grid-cols-12 gap-8">
<!-- Feature 1 -->
<div class="md:col-span-8 group bg-surface-container-lowest rounded-xl overflow-hidden editorial-shadow p-0 flex flex-col md:flex-row h-full">
<div class="flex-1 p-10 flex flex-col justify-center">
<div class="w-12 h-12 rounded-lg bg-primary-container/20 flex items-center justify-center text-primary mb-6">
<span class="material-symbols-outlined" data-icon="post_add">post_add</span>
</div>
<h3 class="font-headline text-3xl font-bold mb-4">Post food easily</h3>
<p class="text-on-surface-variant leading-relaxed mb-6">Upload photos and details of your surplus in seconds. Our editorial engine formats your listing for maximum visibility.</p>
<div class="mt-auto">
<span class="px-4 py-2 bg-surface-container rounded-full text-xs font-bold uppercase tracking-widest text-primary">Efficiency First</span>
</div>
</div>
<div class="flex-1 min-h-[300px] relative overflow-hidden">
<img class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" data-alt="close-up of fresh organic artisan ingredients and hands preparing food in a clean bright kitchen environment" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAsOLgDUwLYd8sR7zx8EihnyfnKRx0BQXZFtur94ZIlTvRXXB1m9sLJ8IKHw_CeKbLju9KPG28h2p_jKVj1ZAr8870PA9RWVBcJ_rgTgYU-EdIO_UpKRtBch5RB_NNvpX4tiYrVIn3VzCj5hELn1MfUGTtyzE9ewr7idFY8QaFVE-qDPprLFybrZ8LRFdOVhBTayBeqkXr-2q7GvOkwne5c_MEZW9Fb2cNTfXQMaSfCX2Xm-8ffWOeURbraPlBQh2FFFLmEH3XaUok"/>
</div>
</div>
<!-- Feature 2 -->
<div class="md:col-span-4 bg-surface-container-lowest rounded-xl overflow-hidden editorial-shadow flex flex-col">
<div class="h-64 relative overflow-hidden">
<img class="w-full h-full object-cover" data-alt="stylized map view on a high-end smartphone showing colorful location markers over a clean urban grid" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBqV2XVSNhmGP8sRc-dZyrmw5Uuh1_MSsnyTNDtbdWVmk9z61B6wyeTbiWX1BLleLxUAv7Z1j8uO5LHojOQjSvLEjy2h-JXfAzbqJYtHq8mIPtAZcVqylnm3H1xkkz2zLdZpI7Xwv727tHpyXiA3Q-eVFqpPGhGJ9WLXAfvY7DVzJGHTdRw-Xbg-jx4eBzMlfgViPaYpB0DZD9s9kBFtTD9GSdEHagLhuaSUOcxM9fA67tQ8BolRI3b-SYwBNwRk1kwR0mldy1VLAE"/>
</div>
<div class="p-10">
<div class="w-12 h-12 rounded-lg bg-secondary-container/30 flex items-center justify-center text-secondary mb-6">
<span class="material-symbols-outlined" data-icon="explore">explore</span>
</div>
<h3 class="font-headline text-2xl font-bold mb-4">Discover nearby food</h3>
<p class="text-on-surface-variant leading-relaxed">Real-time alerts for fresh surplus in your neighborhood. Never miss an opportunity to rescue perfect ingredients.</p>
</div>
</div>
<!-- Feature 3 -->
<div class="md:col-span-12 group bg-tertiary text-on-tertiary rounded-xl overflow-hidden editorial-shadow flex flex-col md:flex-row items-center">
<div class="flex-1 p-12">
<div class="inline-flex items-center gap-3 mb-6 bg-white/10 px-4 py-2 rounded-full">
<span class="material-symbols-outlined" data-icon="eco" style="font-variation-settings: 'FILL' 1;">eco</span>
<span class="font-label font-bold text-sm tracking-widest uppercase">Environmental Agency</span>
</div>
<h3 class="font-headline text-4xl font-extrabold mb-6 tracking-tight">Reduce waste with editorial precision.</h3>
<p class="text-on-tertiary/80 text-lg leading-relaxed max-w-2xl">We track every rescued meal. Join thousands who are turning potential waste into communal nourishment through our high-velocity distribution network.</p>
</div>
<div class="p-12">
<div class="bg-white/10 backdrop-blur-md rounded-2xl p-8 border border-white/10">
<div class="text-5xl font-black mb-1">12.5k</div>
<div class="text-sm font-label uppercase tracking-widest opacity-70">Tons Redirected</div>
</div>
</div>
</div>
</div>
</div>
</section>
<!-- Fresh Feed (Teaser) -->
<section class="py-24 px-8 bg-surface">
<div class="max-w-7xl mx-auto">
<div class="mb-12">
<h2 class="font-headline text-3xl font-extrabold tracking-tight">Live Redistribution Feed</h2>
<p class="text-on-surface-variant">Active surplus waiting for collection now.</p>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
<?php if(empty($live_foods)): ?>
    <div class="col-span-full py-10">
        <p class="text-on-surface-variant italic">No live food right now, be the first to post!</p>
    </div>
<?php else: ?>
    <?php foreach($live_foods as $post): ?>
        <?php 
            $time_left = timeUntil($post['expiry_time']);
            $is_urgent = strpos($time_left, 'mins') !== false || strpos($time_left, 'hours') !== false && intval($time_left) <= 2;
            $img_src = !empty($post['image_url']) ? htmlspecialchars($post['image_url']) : 'https://lh3.googleusercontent.com/aida-public/AB6AXuCQg6QwBWb67ZUSx9_Af1m4uU8suG4LQIJPWckx8UtbfHb5Zv6cyc7puv1JKNNATqAGzTkHUAI1OixqwdQfRwSwKXmnH8LPrig0NaBfDt7c9Ozk5YlEXE2tnXF_rZ1T0jxiMFPbesYjI2Hmzh8M8pskKhrrSovFo5x1I1y_vdIhpG1nyhFCkRYo-k8-Rrr2WjE_FOWet89qkrrK415H9LRPKsYyKP0CRsjtstiWXo-SbMI_fHu_s5PMIaHXIB4ZU5FW7gQAM_pN02U';
        ?>
        <div class="bg-surface-container-lowest rounded-xl overflow-hidden group">
            <div class="aspect-[4/3] relative overflow-hidden">
            <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="<?php echo $img_src; ?>"/>
            <div class="absolute top-4 left-4">
            <span class="px-3 py-1 rounded-full <?php echo $is_urgent ? 'bg-tertiary-container text-on-tertiary-container' : 'bg-secondary-container text-on-secondary-container'; ?> font-label font-bold text-xs uppercase tracking-wider">
                <?php echo $is_urgent ? 'URGENT' : 'Exp ' . $time_left; ?>
            </span>
            </div>
            </div>
            <div class="p-6">
            <h4 class="font-headline font-bold text-xl mb-2"><?php echo htmlspecialchars($post['title']); ?></h4>
            <p class="text-on-surface-variant text-sm mb-4">Qty: <?php echo htmlspecialchars($post['quantity']); ?> • Posted <?php echo timeAgo($post['created_at']); ?></p>
            <div class="flex items-center justify-between">
            <span class="flex items-center gap-1 text-on-surface-variant text-sm truncate max-w-[150px]">
            <span class="material-symbols-outlined text-sm" data-icon="location_on">location_on</span>
                                                <?php echo htmlspecialchars($post['location']); ?>
                                            </span>
            <a href="feed.php" class="text-primary font-bold text-sm flex items-center gap-1 group-hover:gap-2 transition-all">
                                                View <span class="material-symbols-outlined text-sm">arrow_forward</span>
            </a>
            </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
</div>
</div>
</section>
</main>

<?php require_once 'includes/footer.php'; ?>
