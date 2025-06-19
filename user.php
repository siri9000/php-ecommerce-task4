<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    echo "Access denied. Users only.";
    exit;
}
?>

<h2>Welcome User <?php echo $_SESSION['username']; ?>!</h2>
<p>This is your user dashboard.</p>
