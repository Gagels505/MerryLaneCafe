<?php

require '../includes/config.php';

$tab = $_GET['tab'] ?? 'reports';

$topItems = [['Iced Spanish Latte', 24], ['Almond Croissant', 17], ['Pesto Chicken Toast', 11]];
$peak     = [['2 PM', 18], ['3 PM', 14], ['9 AM', 9]];
$reviews  = [
    ['order' => 12, 'rating' => 5, 'comment' => 'Cozy place and the latte was perfect!', 'date' => '2026-10-22 14:40'],
    ['order' => 9,  'rating' => 4, 'comment' => 'Great croissant, a bit of a wait.',     'date' => '2026-10-22 11:05'],
];
$menu = [['Iced Spanish Latte', 'Coffee', 180], ['Almond Croissant', 'Pastries', 140], ['Pesto Chicken Toast', 'Meals', 240]];

$title = 'Admin dashboard';
$wide  = true;
include '../includes/header.php';
?>
<h2>Admin dashboard</h2>

<div class="tabs">
  <?php foreach (['reports' => 'Reports', 'reviews' => 'Reviews', 'hours' => 'Ordering hours', 'menu' => 'Menu', 'qr' => 'Table QR codes'] as $k => $v): ?>
    <a class="<?= $tab === $k ? 'on' : '' ?>" href="?tab=<?= $k ?>"><?= $v ?></a>
  <?php endforeach; ?>
  <a href="<?= BASE_URL ?>/staff/staff_panel.php">Staff panel</a>
  <a href="<?= BASE_URL ?>/logout.php">Log out</a>
</div>

<?php if ($tab === 'reports'): ?>
  <div class="grid2">
    <div class="card"><h3>Sales</h3>Today: <strong>₱4,820.00</strong><br>This week: <strong>₱28,350.00</strong></div>
    <div class="card"><h3>Top items</h3>
      <?php foreach ($topItems as $t) echo e($t[0]) . ' — ' . $t[1] . ' sold<br>'; ?>
    </div>
    <div class="card"><h3>Peak hours</h3>
      <?php foreach ($peak as $p) echo e($p[0]) . ' — ' . $p[1] . ' orders<br>'; ?>
    </div>
  </div>

<?php elseif ($tab === 'reviews'): ?>
  <?php foreach ($reviews as $r): ?>
    <div class="card">
      <strong>Order #<?= $r['order'] ?></strong> · <?= str_repeat('★', $r['rating']) ?> · <?= e($r['date']) ?>
      <p><?= e($r['comment']) ?></p>
      <button class="btn small" type="button"
        onclick='exportReview(<?= json_encode("Order #" . $r["order"]) ?>, <?= (int)$r["rating"] ?>, <?= json_encode($r["comment"]) ?>, <?= json_encode($r["date"]) ?>)'>
        Download as image
      </button>
    </div>
  <?php endforeach; ?>

<?php elseif ($tab === 'hours'): ?>
  <form class="card form-card" onsubmit="return false">
    <label><input type="checkbox" checked> Ordering is open</label><br><br>
    Opening time <input type="time" value="<?= OPEN_TIME ?>">
    Closing time <input type="time" value="<?= CLOSE_TIME ?>">
    Last order time <input type="time" value="<?= LAST_ORDER_TIME ?>">
    <button class="btn" type="button">Save hours</button>
  </form>

<?php elseif ($tab === 'menu'): ?>
  <form class="card form-card" onsubmit="return false">
    <h3>Add menu item</h3>
    <input type="text" placeholder="Name">
    <input type="text" placeholder="Category (e.g. Coffee)">
    <input type="number" placeholder="Price">
    <button class="btn" type="button">Add item</button>
  </form>
  <table>
    <tr><th>Item</th><th>Category</th><th>Price</th><th></th></tr>
    <?php foreach ($menu as $m): ?>
      <tr><td><?= e($m[0]) ?></td><td><?= e($m[1]) ?></td><td><?= peso($m[2]) ?></td>
          <td><button class="btn small bad" type="button">Remove</button></td></tr>
    <?php endforeach; ?>
  </table>

<?php else: ?>
  <?php $base = 'http://' . $_SERVER['HTTP_HOST'] . BASE_URL . '/index.php?table='; ?>
  <div class="grid2">
  <?php for ($n = 1; $n <= 10; $n++): $tn = str_pad($n, 2, '0', STR_PAD_LEFT); ?>
    <div class="card center">
      <strong>Table <?= $tn ?></strong><br>
      <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=<?= urlencode($base . $tn) ?>" alt="QR table <?= $tn ?>">
    </div>
  <?php endfor; ?>
  </div>
<?php endif; ?>

<?php $nav = false; include '../includes/footer.php'; ?>
