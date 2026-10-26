<?php

require 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $page = strpos($email, 'admin') !== false ? '/admin/admin_panel.php' : '/staff/staff_panel.php';
    header('Location: ' . BASE_URL . $page);
    exit;
}

$title = 'Staff login';
include 'includes/header.php';
?>
<h2>Staff & admin login</h2>
<p class="tag">Demo: type "admin@..." for the admin page, anything else for staff.</p>
<form method="post">
  <input type="email" name="email" placeholder="Email" required>
  <input type="password" name="password" placeholder="Password" required>
  <button class="btn" type="submit">Log in</button>
</form>
<?php $nav = false; include 'includes/footer.php'; ?>
