<?php
require_once 'config.php';
requireRole('receiver');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = intval($_POST['post_id'] ?? 0);
    
    if ($post_id > 0) {
        $pdo->beginTransaction();
        try {
            // Check if post is available and secure it
            $stmt = $pdo->prepare("SELECT * FROM food_posts WHERE id = ? AND status = 'available' FOR UPDATE");
            $stmt->execute([$post_id]);
            $post = $stmt->fetch();
            
            if ($post) {
                // Update post status
                $stmt = $pdo->prepare("UPDATE food_posts SET status = 'claimed' WHERE id = ?");
                $stmt->execute([$post_id]);
                
                // Create claim record
                $stmt = $pdo->prepare("INSERT INTO claims (post_id, receiver_id) VALUES (?, ?)");
                $stmt->execute([$post_id, $_SESSION['user_id']]);
                
                $pdo->commit();
                
                // Redirect to success page
                header("Location: claim_success.php?id=" . $post_id);
                exit;
            } else {
                $pdo->rollBack();
                // Post not available
                header("Location: feed.php?error=already_claimed");
                exit;
            }
        } catch (Exception $e) {
            $pdo->rollBack();
            header("Location: feed.php?error=system_error");
            exit;
        }
    }
}
header('Location: feed.php');
exit;
?>
