<?php
// config.php
session_start();
date_default_timezone_set('Asia/Kolkata');

// Database credentials (Environment Variables with Local Development Fallbacks)
$db_host = getenv('DB_HOST') ?: 'localhost';
$db_name = getenv('DB_NAME') ?: 'foodshare';
$db_user = getenv('DB_USER') ?: 'root';
$db_pass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : '';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->exec("SET time_zone = '+05:30'");
    try { $pdo->exec("ALTER TABLE food_posts ADD COLUMN contact_phone VARCHAR(20) DEFAULT NULL"); } catch(PDOException $e) {}
} catch (PDOException $e) {
    // Determine if it's a connection error (e.g. database doesn't exist)
    die("Database connection failed: Check config.php settings or ensure database '$db_name' exists in MySQL. Error: " . $e->getMessage());
}

// Ensure the user is logged in
function requireLogin() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: auth.php');
        exit;
    }
}

// Ensure user has specific role
function requireRole($role) {
    requireLogin();
    if ($_SESSION['role'] !== $role) {
        header('Location: index.php'); // Or some error page
        exit;
    }
}

// Calculate relative time or time left
function timeUntil($datetime) {
    $now = new DateTime();
    $target = new DateTime($datetime);
    $interval = $now->diff($target);
    
    if ($now > $target) {
        return "Expired";
    }

    if ($interval->d > 0) {
        return $interval->d . " days";
    } elseif ($interval->h > 0) {
        return $interval->h . " hours";
    } else {
        return $interval->i . " mins";
    }
}

function timeAgo($datetime) {
    $now = new DateTime();
    $target = new DateTime($datetime);
    $interval = $now->diff($target);
    
    if ($now < $target) {
        return "Just now";
    }

    if ($interval->d > 0) {
        return $interval->d . " days";
    } elseif ($interval->h > 0) {
        return $interval->h . " hours";
    } elseif ($interval->i > 0) {
        return $interval->i . " mins";
    } else {
        return "Just now";
    }
}
?>
