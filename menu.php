<?php

require 'includes/config.php';

$items = sample_menu();           
$cat   = $_GET['cat'] ?? 'All';    

$cats = ['All'];
foreach ($items as $it) {
    if (!in_array($it['category'], $cats)) $cats[] = $it['category'];
}

$title = 'Menu';
include 'includes/header.php';
?>

<p>
  <span class="table-tag">Table <?= e($_SESSION['table'] ?? '01') ?></span>
  <span class="tag"><?= e($_SESSION['order_type'] ?? 'dine-in') ?></span>
</p>
<h2>Made for your little pause.</h2>
<p class="page-sub">Pick what you love, we'll bring it over.</p>

<input type="text" id="search" class="search" placeholder="Find your next favorite" oninput="filterMenu()">

<div class="tabs">
  <?php foreach ($cats as $c): ?>
    <a class="<?= $cat === $c ? 'on' : '' ?>" href="?cat=<?= urlencode($c) ?>"><?= e($c) ?></a>
  <?php endforeach; ?>
</div>

<?= isset($_GET['err']) ? '<div class="notice bad">' . e($_GET['err']) . '</div>' : '' ?>

<h3>Neighborhood favorites</h3>

<form action="process.php" method="post">
  <input type="hidden" name="action" value="place">

  <?php foreach ($items as $it):
    if ($cat !== 'All' && $it['category'] !== $cat) continue;
    $out = $it['stock'] === 'out'; 
  ?>
    <div class="card item menu-item <?= $out ? 'off' : '' ?>" data-name="<?= e(strtolower($it['name'])) ?>">
      <div>
        <strong><?= e($it['name']) ?></strong><br>
        <small><?= e($it['desc']) ?></small><br>
        <span class="price"><?= peso($it['price']) ?></span>
        <?php if ($out): ?><span class="tag bad">Out of stock</span>
        <?php elseif ($it['stock'] === 'few'): ?><span class="tag">Few left</span><?php endif; ?>
      </div>

      <?php if (!$out): ?>
      <div class="stepper">
        <button type="button" onclick="changeQty(this,-1)">−</button>
        <input type="text" name="qty[<?= $it['id'] ?>]" value="0" data-price="<?= $it['price'] ?>" readonly>
        <button type="button" onclick="changeQty(this,1)">+</button>
      </div>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>

  <div class="sticky-total">
    <span><span id="count">0</span> items · <strong id="total">₱0.00</strong></span>
    <button class="btn small" type="submit">View cart / Place order</button>
  </div>
</form>

<p class="fineprint">
  New orders accepted until <?= date('g:i A', strtotime(LAST_ORDER_TIME)) ?> today.
</p>

<?php include 'includes/footer.php'; ?>
