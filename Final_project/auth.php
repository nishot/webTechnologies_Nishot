<?php
require_once 'config.php';

if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
$action = $_POST['action'] ?? 'login';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($action === 'register') {
        $name = $_POST['name'] ?? '';
        $role = $_POST['role'] ?? '';
        
        if ($name && $email && $password && $role) {
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                $error = "Email already registered.";
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO users (name, email, password_hash, role) VALUES (?, ?, ?, ?)");
                if ($stmt->execute([$name, $email, $hash, $role])) {
                    $_SESSION['user_id'] = $pdo->lastInsertId();
                    $_SESSION['name'] = $name;
                    $_SESSION['role'] = $role;
                    header('Location: dashboard.php');
                    exit;
                } else {
                    $error = "Registration failed.";
                }
            }
        } else {
            $error = "Please fill all fields.";
        }
    } elseif ($action === 'login') {
        if ($email && $password) {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();
            
            if ($user && password_verify($password, $user['password_hash'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['role'] = $user['role'];
                header('Location: dashboard.php');
                exit;
            } else {
                $error = "Invalid email or password.";
            }
        } else {
            $error = "Please enter email and password.";
        }
    }
}
$page_title = 'FoodShare - Join the Movement';
require_once 'includes/header.php';
?>
<!-- Main Content Canvas -->
<main class="flex-grow flex items-center justify-center pt-24 pb-12 px-6 relative overflow-hidden">
<!-- Background Editorial Element (Asymmetric) -->
<div class="absolute top-0 right-0 w-1/3 h-full bg-surface-container-low -z-10 translate-x-1/4 skew-x-12"></div>
<div class="absolute bottom-0 left-0 w-64 h-64 bg-primary-container/10 rounded-full blur-3xl -z-10 -translate-x-1/2 translate-y-1/2"></div>
<div class="w-full max-w-[1100px] grid md:grid-cols-2 gap-0 bg-surface-container-lowest rounded-xl shadow-2xl overflow-hidden min-h-[600px]">
<!-- Visual Editorial Side -->
<div class="hidden md:block relative overflow-hidden group">
<img class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" data-alt="dramatic high-angle shot of fresh organic vegetables and artisan bread arranged artistically on a light linen cloth with natural window lighting" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBZNB96tkjZ9ibE8cCCVaw6tNE7ioUkl-NyXEpJDU40pYEjNalc_DY13MiMcsF4k8MttQ7B1mm5OfJ-sjzdzfUpuSEIagcR02kDs5dKLBHlH-LOvzQngLyJdrumHeBZBQAdNA2EWmV2pkj3HeBCOFKEw2JEQmTLDA0ssglRB3-QnTQq8k7i69LpNzsXRzyyjWYUxabiLHpMQWgwwKt-dGHfWyd2W4lSU8S0FD5V49Ch_vb4z_wZUifvhW-kuQEbCfmBcxSE6U_YG3Q"/>
<div class="absolute inset-0 bg-gradient-to-t from-emerald-950/80 via-transparent to-transparent"></div>
<div class="absolute bottom-12 left-12 right-12 text-white">
<span class="inline-block px-3 py-1 bg-primary-container text-on-primary-container text-[10px] font-bold tracking-widest uppercase rounded-full mb-4">The Living Archive</span>
<h2 class="text-4xl font-black leading-tight tracking-tighter mb-4">Dignity in Every Surplus Meal.</h2>
<p class="text-emerald-50/80 font-medium leading-relaxed">Join a sophisticated network redistributing high-quality surplus food to those who need it most.</p>
</div>
</div>
<!-- Auth Form Side -->
<div class="p-8 md:p-12 lg:p-16 flex flex-col justify-center bg-surface-container-lowest">
<div class="mb-10 text-center md:text-left">
<h1 class="text-3xl font-black tracking-tighter text-on-surface mb-2" id="form-title">Create Your Account</h1>
<p class="text-on-surface-variant text-sm font-medium" id="form-subtitle">Join our community and start your impact today.</p>
</div>

<?php if($error): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<!-- Toggle -->
<div class="flex p-1 bg-surface-container-high rounded-xl mb-8">
<button type="button" id="tab-login" class="flex-1 py-2 text-sm font-bold rounded-lg transition-all text-on-surface-variant hover:text-on-surface">Login</button>
<button type="button" id="tab-register" class="flex-1 py-2 text-sm font-bold rounded-lg transition-all bg-surface-container-lowest shadow-sm text-primary">Register</button>
</div>
<!-- Registration Fields -->
<form method="POST" action="auth.php" class="space-y-6">
<input type="hidden" name="action" id="action-input" value="register">

<div class="space-y-4">
<!-- Name Field -->
<div class="group" id="field-name">
<label class="block text-[10px] font-bold tracking-widest text-outline uppercase mb-1.5 ml-1">Full Name</label>
<div class="relative">
<span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline-variant text-xl">person</span>
<input name="name" id="input-name" class="w-full pl-12 pr-4 py-3.5 bg-surface-container-highest border-none rounded-xl focus:ring-2 focus:ring-primary/20 focus:scale-[1.01] transition-all placeholder:text-outline-variant text-on-surface" placeholder="John Doe" type="text" required/>
</div>
</div>
<!-- Email Field -->
<div class="group">
<label class="block text-[10px] font-bold tracking-widest text-outline uppercase mb-1.5 ml-1">Email Address</label>
<div class="relative">
<span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline-variant text-xl">alternate_email</span>
<input name="email" required class="w-full pl-12 pr-4 py-3.5 bg-surface-container-highest border-none rounded-xl focus:ring-2 focus:ring-primary/20 focus:scale-[1.01] transition-all placeholder:text-outline-variant text-on-surface" placeholder="john@example.com" type="email"/>
</div>
</div>
<!-- Password Field -->
<div class="group">
<label class="block text-[10px] font-bold tracking-widest text-outline uppercase mb-1.5 ml-1">Password</label>
<div class="relative">
<span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline-variant text-xl">lock</span>
<input name="password" required class="w-full pl-12 pr-4 py-3.5 bg-surface-container-highest border-none rounded-xl focus:ring-2 focus:ring-primary/20 focus:scale-[1.01] transition-all placeholder:text-outline-variant text-on-surface" placeholder="••••••••" type="password"/>
</div>
</div>
<!-- Role Selection (Dropdown) -->
<div class="group" id="field-role">
<label class="block text-[10px] font-bold tracking-widest text-outline uppercase mb-1.5 ml-1">Your Role</label>
<div class="relative">
<span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline-variant text-xl">diversity_3</span>
<select name="role" id="input-role" class="w-full pl-12 pr-4 py-3.5 bg-surface-container-highest border-none rounded-xl focus:ring-2 focus:ring-primary/20 focus:scale-[1.01] appearance-none transition-all text-on-surface" required>
<option disabled="" selected="" value="">Select your purpose</option>
<option value="donor">Food Donor (Restaurant/Store)</option>
<option value="receiver">Food Receiver (Community Group)</option>
</select>
<span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-outline-variant pointer-events-none">expand_more</span>
</div>
</div>
</div>
<!-- CTA Button -->
<button id="submit-btn" class="w-full py-4 bg-gradient-to-r from-primary to-primary-container text-on-primary font-black tracking-tight rounded-xl shadow-lg shadow-primary/20 hover:shadow-xl hover:shadow-primary/30 active:scale-95 transition-all mt-4" type="submit">Create Account</button>
</form>
<div class="mt-8 pt-8 border-t border-surface-container-high text-center">
<p class="text-on-surface-variant text-xs">
                        By continuing, you agree to FoodShare's Terms of Service and Privacy Policy.
                    </p>
</div>
</div>
</div>
</main>

<div id="auth-action-data" data-action="<?php echo htmlspecialchars($action); ?>" class="hidden"></div>
<script src="assets/js/auth.js"></script>

<?php require_once 'includes/footer.php'; ?>
