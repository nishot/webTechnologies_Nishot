<?php
require_once 'config.php';

// Feed logic: fetch all 'available' food posts from DB
$stmt = $pdo->query("SELECT f.*, u.name as donor_name FROM food_posts f JOIN users u ON f.donor_id = u.id WHERE f.status = 'available' ORDER BY f.expiry_time ASC");
$posts = $stmt->fetchAll();
$page_title = 'FoodShare | The Daily Feed';
require_once 'includes/header.php';
?>

    <main class="flex-grow pt-28 pb-12 px-8 max-w-7xl mx-auto w-full">
        <!-- Editorial Header -->
        <section class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div class="max-w-2xl">
                <h1 class="text-5xl font-headline font-extrabold tracking-tighter text-on-surface mb-4">The Daily Feed</h1>
                <p class="text-lg text-on-surface-variant leading-relaxed">Curated surplus from local artisans and retailers. High-quality food redistribution with journalistic precision.</p>
            </div>
        </section>

        <!-- Bento Grid of Food Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php if(empty($posts)): ?>
                <div class="col-span-full py-20 text-center">
                    <h3 class="text-2xl font-bold font-headline text-gray-700">No surplus food available right now.</h3>
                    <p class="text-gray-500 mt-2">Check back later for fresh updates from our donor network.</p>
                </div>
            <?php else: ?>
                <?php foreach($posts as $post): ?>
                    <?php 
                        $time_left = timeUntil($post['expiry_time']);
                        $is_urgent = strpos($time_left, 'mins') !== false || strpos($time_left, 'hours') !== false && intval($time_left) <= 2;
                        $img_src = !empty($post['image_url']) ? htmlspecialchars($post['image_url']) : 'https://lh3.googleusercontent.com/aida-public/AB6AXuCQg6QwBWb67ZUSx9_Af1m4uU8suG4LQIJPWckx8UtbfHb5Zv6cyc7puv1JKNNATqAGzTkHUAI1OixqwdQfRwSwKXmnH8LPrig0NaBfDt7c9Ozk5YlEXE2tnXF_rZ1T0jxiMFPbesYjI2Hmzh8M8pskKhrrSovFo5x1I1y_vdIhpG1nyhFCkRYo-k8-Rrr2WjE_FOWet89qkrrK415H9LRPKsYyKP0CRsjtstiWXo-SbMI_fHu_s5PMIaHXIB4ZU5FW7gQAM_pN02U';
                    ?>
                    <div class="group bg-surface-container-lowest rounded-xl overflow-hidden flex flex-col editorial-shadow transition-all hover:translate-y-[-4px] border border-gray-100">
                        <div class="relative h-56 bg-gray-200 overflow-hidden flex items-center justify-center">
                            <!-- Placeholder image tailored to Food -->
                            <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="<?php echo $img_src; ?>">
                            
                            <div class="absolute top-4 right-4 flex flex-col gap-2 items-end">
                                <?php if($is_urgent): ?>
                                    <span class="bg-tertiary-container text-on-tertiary-container px-3 py-1 rounded-full text-[10px] font-bold tracking-[0.1em] uppercase shadow-sm bg-white/90 backdrop-blur-sm">URGENT</span>
                                <?php else: ?>
                                    <span class="bg-secondary-container text-on-secondary-container px-3 py-1 rounded-full text-[10px] font-bold tracking-[0.1em] uppercase shadow-sm bg-white/90 backdrop-blur-sm">Available</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-xl font-headline font-bold tracking-tight"><?php echo htmlspecialchars($post['title']); ?></h3>
                                <span class="<?php echo $is_urgent ? 'text-red-600' : 'text-primary'; ?> font-bold text-sm flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm">schedule</span> <?php echo $time_left; ?>
                                </span>
                            </div>
                            <div class="flex items-center gap-4 text-sm text-gray-500 mb-6 flex-wrap">
                                <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">inventory_2</span> <?php echo htmlspecialchars($post['quantity']); ?></span>
                                <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">location_on</span> <?php echo htmlspecialchars($post['location']); ?></span>
                                <span class="flex items-center gap-1 w-full mt-1 text-xs"><span class="material-symbols-outlined text-xs">storefront</span> <?php echo htmlspecialchars($post['donor_name']); ?></span>
                            </div>
                            
                            <div class="mt-auto flex gap-3">
                                <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'receiver'): ?>
                                    <form action="claim_food.php" method="POST" class="w-full m-0">
                                        <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                                        <button type="submit" class="w-full bg-gradient-to-r from-primary to-primary-container text-white py-3 rounded-xl font-bold tracking-tight hover:opacity-90 active:scale-95 transition-all shadow-md">
                                            Claim
                                        </button>
                                    </form>
                                <?php elseif(!isset($_SESSION['role'])): ?>
                                    <a href="auth.php" class="w-full bg-surface-container-highest text-on-surface py-3 rounded-xl font-bold tracking-tight text-center block hover:bg-surface-variant transition-colors">
                                        Login to Claim
                                    </a>
                                <?php else: ?>
                                    <button disabled class="w-full bg-gray-200 text-gray-500 py-3 rounded-xl font-bold tracking-tight cursor-not-allowed">
                                        Receivers Only
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>

    <?php require_once 'includes/footer.php'; ?>
