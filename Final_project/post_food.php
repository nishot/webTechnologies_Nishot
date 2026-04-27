<?php
require_once 'config.php';
requireRole('donor');

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $quantity = trim($_POST['quantity'] ?? '');
    $expiry_time = $_POST['expiry_time'] ?? '';
    $location = trim($_POST['location'] ?? '');
    $contact_phone = trim($_POST['contact_phone'] ?? '');
    
    $image_url = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $filename = time() . '_' . basename($_FILES['image']['name']);
        $target_path = $upload_dir . $filename;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
            $image_url = $target_path;
        }
    }
    
    if ($title && $quantity && $expiry_time && $location && $contact_phone) {
        $stmt = $pdo->prepare("INSERT INTO food_posts (donor_id, title, quantity, location, expiry_time, contact_phone, image_url) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$_SESSION['user_id'], $title, $quantity, $location, $expiry_time, $contact_phone, $image_url])) {
            $success = true;
        } else {
            $error = "Failed to post food.";
        }
    } else {
        $error = "Please fill in all required fields.";
    }
}
$page_title = 'Post Food | FoodShare';
require_once 'includes/header.php';
?>

<main class="flex-grow pt-32 pb-20 px-6 flex items-center justify-center relative overflow-hidden">
    <div class="absolute top-[-10%] left-[-5%] w-96 h-96 bg-primary-container/10 rounded-full blur-3xl -z-10"></div>
    <div class="absolute bottom-[-10%] right-[-5%] w-[30rem] h-[30rem] bg-tertiary-container/10 rounded-full blur-3xl -z-10"></div>
    
    <?php if ($success): ?>
    <!-- ==================== SUCCESS SCREEN ==================== -->
    <div class="max-w-4xl w-full grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
        
        <!-- Visual Component -->
        <div class="relative group">
            <div class="absolute -inset-4 bg-primary-container/20 rounded-3xl blur-2xl group-hover:bg-primary-container/30 transition-all duration-500"></div>
            <div class="relative aspect-[4/5] rounded-xl overflow-hidden bg-surface-container-highest shadow-xl">
                <img class="w-full h-full object-cover grayscale-[0.2] group-hover:grayscale-0 transition-all duration-700" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBIwQYmcKviff7xiRQe-esEH4sjA1pN_5iypypf-SJZiudWRaEBbRlFDcNrXS7hCY1wBj70Rj2y7dDg7vClQwNYVkZ9EA6R14Uau80_-K74Iwpz5pRUqF58a8vEbKMey2-56vdYNIG_2QmG9RfVVXsf6V138uiHG7JBkkS54-gTQjoyE1bvIh5DAY0Mb44LZAPP4rb4fJh69RIIGxBrpS4kam41tep3VTLkGqrHTvME3rZd057C2dLOdniy5zhEc5KLy5haUMrzlg0" alt="Success Food Image"/>
                <div class="absolute inset-0 bg-gradient-to-t from-primary/60 to-transparent flex items-end p-8">
                    <div class="text-white">
                        <span class="inline-block px-3 py-1 rounded-full bg-primary-container text-on-primary-container text-[10px] font-bold tracking-widest uppercase mb-3">Community Impact</span>
                        <p class="font-headline font-bold text-xl leading-tight">Your contribution just reduced local waste by another 5kg.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Details -->
        <div class="flex flex-col space-y-8">
            <header class="space-y-4">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-primary-container text-on-primary-container shadow-lg">
                    <span class="material-symbols-outlined !text-4xl" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                </div>
                <h1 class="font-headline text-5xl font-extrabold tracking-tighter text-on-surface leading-[0.95]">
                    Your food has <br/> been posted <br/> successfully
                </h1>
                <p class="text-on-surface-variant text-lg max-w-md font-medium leading-relaxed">
                    The FoodShare community has been notified. Local collectors will be able to see your listing on the public feed immediately.
                </p>
            </header>

            <div class="p-6 rounded-xl bg-surface-container-low border-l-4 border-primary">
                <h3 class="font-headline font-bold text-sm text-primary uppercase tracking-widest mb-2">Next Steps</h3>
                <ul class="space-y-3">
                    <li class="flex items-start gap-3 text-sm text-on-surface-variant">
                        <span class="material-symbols-outlined text-primary scale-75">notifications_active</span> Keep an eye on your messages for pickup requests.
                    </li>
                    <li class="flex items-start gap-3 text-sm text-on-surface-variant">
                        <span class="material-symbols-outlined text-primary scale-75">schedule</span> Listings typically receive interest within 45 minutes.
                    </li>
                </ul>
            </div>

            <div class="flex items-center gap-4 pt-2">
                <a href="dashboard.php" class="inline-flex items-center px-8 py-4 rounded-xl bg-gradient-to-r from-primary to-primary-container text-white font-bold text-lg shadow-lg hover:shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all duration-200">Back to Dashboard</a>
                <a href="post_food.php" class="p-4 rounded-xl text-primary font-bold hover:bg-surface-container-high transition-all">Post More</a>
            </div>
        </div>
    </div>
    
    <?php else: ?>
    <!-- ==================== POST FORM SCREEN ==================== -->
    <div class="max-w-2xl w-full">
        <!-- Editorial Header -->
        <div class="mb-12 text-center md:text-left">
            <span class="text-tertiary font-label font-semibold tracking-[0.2em] uppercase text-xs mb-3 block">Donor Initiative</span>
            <h1 class="text-4xl md:text-5xl font-headline font-extrabold text-on-surface tracking-tight leading-none mb-4">
                Share Your Surplus. <br/>
                <span class="text-primary">Feed the Community.</span>
            </h1>
            <p class="text-on-surface-variant font-body text-lg max-w-lg leading-relaxed">
                Transform excess inventory into impact. High-quality redistribution begins with accurate details.
            </p>
        </div>

        <?php if($error): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-8 shadow-sm">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <!-- Form Container -->
        <div class="bg-surface-container-lowest rounded-xl p-8 md:p-12 shadow-[0_8px_32px_rgba(44,62,80,0.04)] relative">
            <form class="space-y-8" method="POST" action="post_food.php" enctype="multipart/form-data">

                <!-- Title -->
                <div class="group relative space-y-2">
                    <label class="block font-headline font-bold text-sm text-on-surface-variant tracking-wide">Food Name</label>
                    <div class="group relative flex items-center">
                        <input name="title" required class="w-full bg-surface-container-highest border-none rounded-lg p-4 font-body focus:ring-0 focus:bg-white transition-all duration-200 text-on-surface placeholder:text-outline-variant" placeholder="e.g. Organic Sourdough Boules" type="text"/>
                        <div class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-focus-within:w-full"></div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Quantity -->
                    <div class="group relative space-y-2">
                        <label class="block font-headline font-bold text-sm text-on-surface-variant tracking-wide">Quantity</label>
                        <div class="group relative flex items-center">
                            <input name="quantity" required class="w-full bg-surface-container-highest border-none rounded-lg p-4 font-body focus:ring-0 focus:bg-white transition-all duration-200 text-on-surface placeholder:text-outline-variant" placeholder="e.g. 15 Units / 5kg" type="text"/>
                            <div class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-focus-within:w-full"></div>
                        </div>
                    </div>
                    <!-- Expiry -->
                    <div class="group relative space-y-2">
                        <label class="block font-headline font-bold text-sm text-on-surface-variant tracking-wide">Expiry Time</label>
                        <div class="group relative flex items-center">
                            <input name="expiry_time" required class="w-full bg-surface-container-highest border-none rounded-lg p-4 font-body focus:ring-0 focus:bg-white transition-all duration-200 text-on-surface placeholder:text-outline-variant" type="datetime-local"/>
                            <div class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-focus-within:w-full"></div>
                        </div>
                    </div>
                </div>

                <!-- Location Field -->
                <div class="group relative space-y-2">
                    <label class="block font-headline font-bold text-sm text-on-surface-variant tracking-wide">Pickup Location</label>
                    <div class="group relative flex items-center">
                        <span class="material-symbols-outlined absolute left-4 text-outline-variant" data-icon="location_on">location_on</span>
                        <input name="location" id="location-input" required class="w-full bg-surface-container-highest border-none rounded-lg p-4 font-body focus:ring-0 focus:bg-white transition-all duration-200 text-on-surface placeholder:text-outline-variant pl-12 pr-14" placeholder="Enter pickup address" type="text"/>
                        <button type="button" id="get-location-btn" title="Use Current Location" class="absolute right-3 text-primary hover:text-emerald-800 transition-colors p-1.5 rounded-full hover:bg-surface-container-low flex items-center justify-center">
                            <span class="material-symbols-outlined text-[20px]">my_location</span>
                        </button>
                        <div class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-focus-within:w-full"></div>
                    </div>
                </div>

                <!-- Contact Phone -->
                <div class="group relative space-y-2">
                    <label class="block font-headline font-bold text-sm text-on-surface-variant tracking-wide">Contact Phone</label>
                    <div class="group relative flex items-center">
                        <span class="material-symbols-outlined absolute left-4 text-outline-variant" data-icon="call">call</span>
                        <input name="contact_phone" required class="w-full bg-surface-container-highest border-none rounded-lg p-4 font-body focus:ring-0 focus:bg-white transition-all duration-200 text-on-surface placeholder:text-outline-variant pl-12 pr-4" placeholder="e.g. +1 555-123-4567" type="tel"/>
                        <div class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-focus-within:w-full"></div>
                    </div>
                </div>

                <!-- Food Image Upload -->
                <div class="group relative space-y-2">
                    <label class="block font-headline font-bold text-sm text-on-surface-variant tracking-wide">Food Image</label>
                    <div class="group relative cursor-pointer">
                        <div class="w-full aspect-video md:aspect-[21/9] bg-surface-container-highest border-2 border-dashed border-outline-variant rounded-xl flex flex-col items-center justify-center gap-3 transition-all duration-200 hover:bg-white hover:border-primary group-focus-within:bg-white group-focus-within:border-primary">
                            <span class="material-symbols-outlined text-4xl text-outline-variant group-hover:text-primary transition-colors" data-icon="add_a_photo">add_a_photo</span>
                            <div class="text-center px-4" id="upload-text">
                                <p class="font-headline font-bold text-on-surface tracking-tight leading-none mb-1">Upload Food Image</p>
                                <p class="font-body text-xs text-on-surface-variant">Click to upload (Max 5MB)</p>
                            </div>
                            <input name="image" id="image-input" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer" type="file"/>
                        </div>
                        <div class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-focus-within:w-full"></div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button class="w-full py-4 px-6 bg-gradient-to-r from-primary to-primary-container text-on-primary font-headline font-extrabold text-lg rounded-xl shadow-lg hover:shadow-xl active:scale-[0.98] transition-all duration-200 flex items-center justify-center gap-3" type="submit">
                        <span class="material-symbols-outlined" data-icon="rocket_launch">rocket_launch</span>
                        Post Listing
                    </button>
                </div>
            </form>

            <script src="assets/js/post_food.js"></script>

            <!-- Tooltip -->
            <div class="mt-8 flex gap-4 p-4 rounded-lg bg-surface-container-low">
                <span class="material-symbols-outlined text-tertiary" data-icon="info">info</span>
                <p class="text-sm font-body text-on-surface-variant italic">
                    Tip: Accurate expiry times help our couriers prioritize your pickup to ensure zero waste.
                </p>
            </div>
        </div>
    </div>
    <?php endif; ?>
</main>

<?php require_once 'includes/footer.php'; ?>
