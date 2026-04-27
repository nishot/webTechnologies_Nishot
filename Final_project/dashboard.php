<?php
require_once 'config.php';
requireLogin();

if ($_SESSION['role'] === 'donor') {
    require_once 'donor_dashboard.php';
} else {
    require_once 'receiver_dashboard.php';
}
?>
