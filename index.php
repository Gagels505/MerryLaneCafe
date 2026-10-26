<?php

require 'includes/config.php';


if (isset($_GET['table'])) {
    $_SESSION['table'] = preg_replace('/[^0-9A-Za-z]/', '', $_GET['table']);
}
$table = $_SESSION['table'] ?? '01'; 

$title   = 'Welcome';
$minLoad = 2000;   
include 'includes/header.php';
?>

<!-- Welcome card -->
<div class="hero">
  <img src="<?= BASE_URL ?>/assets/images/logo.png" alt="Merrylane Café" onerror="this.remove()">
  <h1>Your cozy corner awaits.</h1>
  <p>You're at Table <?= e($table) ?>. Settle in, find your favorite, and we'll take care of the rest.</p>
  <span class="table-tag">Table <?= e($table) ?></span>
</div>

<form action="process.php" method="post">
  <input type="hidden" name="action" value="start">
  <h3>How are you enjoying today?</h3>
  <div class="choice">
    <label><input type="radio" name="order_type" value="dine-in" checked><span>Dine-in<br><small>Served to Table <?= e($table) ?></small></span></label>
    <label><input type="radio" name="order_type" value="take-out"><span>Take-out<br><small>Packed for your day</small></span></label>
  </div>
  <button class="btn" type="submit">Explore the menu</button>
</form>

<p class="fineprint">
  Open <?= date('g:i A', strtotime(OPEN_TIME)) ?> – <?= date('g:i A', strtotime(CLOSE_TIME)) ?>
  · Last order at <?= date('g:i A', strtotime(LAST_ORDER_TIME)) ?>
</p>

<?php include 'includes/footer.php'; ?>
