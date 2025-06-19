<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "Access denied. Admins only.";
    exit;
}
?>

<h2>Welcome Admin <?php echo $_SESSION['username']; ?>!</h2>
<p>This is the admin dashboard.</p>
