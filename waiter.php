<?php

require 'includes/config.php';
$title = 'Call waiter';
include 'includes/header.php';
?>
<h2>Call a waiter</h2>
<p class="page-sub">Table <?= e($_SESSION['table'] ?? '01') ?> · tap a reason and we'll be right over.</p>
<?= isset($_GET['sent']) ? '<div class="notice ok">A staff member is on the way.</div>' : '' ?>

<form action="process.php" method="post" class="btn-stack">
  <input type="hidden" name="action" value="waiter">
  <?php foreach (['Need water', 'Need utensils', 'Ask about the menu', 'Request the bill', 'Other'] as $r): ?>
    <button class="btn alt" name="reason" value="<?= e($r) ?>"><?= e($r) ?></button>
  <?php endforeach; ?>
</form>
<?php include 'includes/footer.php'; ?>
