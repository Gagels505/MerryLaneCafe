<?php
require '../includes/config.php';

$tab = $_GET['tab'] ?? 'payments'; 
$payments = [
    ['id' => 12, 'table' => '07', 'type' => 'dine-in',  'total' => 320, 'method' => 'gcash'],
    ['id' => 13, 'table' => '03', 'type' => 'take-out', 'total' => 140, 'method' => 'counter'],
];
$queue = [
    ['no' => 1, 'table' => '05', 'type' => 'dine-in',  'status' => 'preparing', 'items' => ['1 × Iced Spanish Latte', '1 × Almond Croissant']],
    ['no' => 2, 'table' => '02', 'type' => 'take-out', 'status' => 'queued',    'items' => ['2 × Americano']],
];
$stock = [
    ['name' => 'Iced Spanish Latte',  'status' => 'Available'],
    ['name' => 'Almond Croissant',    'status' => 'Available'],
    ['name' => 'Basque Cheesecake',   'status' => 'Out of stock (today)'],
];
$calls = [
    ['table' => '07', 'reason' => 'Need water',       'time' => '2:34 PM'],
    ['table' => '04', 'reason' => 'Request the bill', 'time' => '2:36 PM'],
];

$title = 'Staff panel';
$wide  = true;  
include '../includes/header.php';
?>
<h2>Staff panel</h2>
<div class="tabs">
  <?php foreach (['payments' => 'Payments', 'queue' => 'Queue', 'stock' => 'Stock', 'calls' => 'Waiter calls'] as $k => $v): ?>
    <a class="<?= $tab === $k ? 'on' : '' ?>" href="?tab=<?= $k ?>"><?= $v ?></a>
  <?php endforeach; ?>
  <a href="<?= BASE_URL ?>/logout.php">Log out</a>
</div>

<?php if ($tab === 'payments'): ?>
  <div class="grid2">
  <?php foreach ($payments as $p): ?>
    <div class="card">
      <strong>Order #<?= $p['id'] ?></strong> · Table <?= e($p['table']) ?> · <?= e($p['type']) ?><br>
      <?= peso($p['total']) ?> · <?= e($p['method']) ?>
      <?php if ($p['method'] === 'gcash'): ?>
        <p class="tag">GCash screenshot appears here</p>
      <?php endif; ?>
      <div class="row">
        <button class="btn small ok" type="button">Confirm</button>
        <?php if ($p['method'] === 'gcash'): ?><button class="btn small bad" type="button">Reject screenshot</button><?php endif; ?>
      </div>
    </div>
  <?php endforeach; ?>
  </div>

<?php elseif ($tab === 'queue'): ?>
  <div class="grid2">
  <?php foreach ($queue as $q): ?>
    <div class="card">
      <div class="queue">#<?= $q['no'] ?></div>
      Table <?= e($q['table']) ?> · <?= e($q['type']) ?> · <span class="tag"><?= e($q['status']) ?></span>
      <ul><?php foreach ($q['items'] as $i): ?><li><?= e($i) ?></li><?php endforeach; ?></ul>
      <div class="row">
        <button class="btn small alt" type="button">Preparing</button>
        <button class="btn small alt" type="button">Ready</button>
        <button class="btn small ok" type="button">Completed</button>
      </div>
    </div>
  <?php endforeach; ?>
  </div>

<?php elseif ($tab === 'stock'): ?>
  <table>
    <tr><th>Item</th><th>Status</th><th>Orders left (optional)</th><th></th></tr>
    <?php foreach ($stock as $s): ?>
    <tr>
      <td><?= e($s['name']) ?></td>
      <td>
        <select>
          <option>Available</option>
          <option>Out of stock (today)</option>
          <option>Out of stock (until changed)</option>
        </select>
      </td>
      <td><input type="number" min="0"></td>
      <td><button class="btn small" type="button">Save</button></td>
    </tr>
    <?php endforeach; ?>
  </table>

<?php else: ?>
  <?php foreach ($calls as $c): ?>
    <div class="card item">
      <span><strong>Table <?= e($c['table']) ?></strong> · <?= e($c['reason']) ?> · <?= e($c['time']) ?></span>
      <button class="btn small ok" type="button">Done</button>
    </div>
  <?php endforeach; ?>
<?php endif; ?>

<?php $nav = false; include '../includes/footer.php'; ?>
