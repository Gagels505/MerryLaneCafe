<?php

require 'includes/config.php';

$flow = ['awaiting_payment', 'pending', 'queued', 'preparing', 'ready', 'completed'];
if (isset($_GET['demo_next']) && isset($_SESSION['orders'][(int)$_GET['demo_next']])) {
    $o = &$_SESSION['orders'][(int)$_GET['demo_next']];
    $pos = array_search($o['status'], $flow);
    if ($pos !== false && $pos < count($flow) - 1) $o['status'] = $flow[$pos + 1];
    unset($o);
    header('Location: ' . BASE_URL . '/orders.php');
    exit;
}

$orders = array_reverse(my_orders());  
$steps = ['queued' => 1, 'preparing' => 2, 'ready' => 3, 'completed' => 4];

$title = 'My order';
include 'includes/header.php';
?>
<h2>My order</h2>
<?= isset($_GET['thanks']) ? '<div class="notice ok">Thanks for your review!</div>' : '' ?>
<?php if (!$orders): ?>
  <p>No orders yet. <a href="menu.php">Browse the menu</a>.</p>
<?php endif; ?>

<?php foreach ($orders as $o): ?>
  <div class="card">
    <strong>Order #<?= $o['id'] ?></strong> · <?= e($o['type']) ?> · <?= peso($o['total']) ?>
    <ul>
      <?php foreach ($o['items'] as $i): ?>
        <li><?= (int)$i['qty'] ?> × <?= e($i['name']) ?></li>
      <?php endforeach; ?>
    </ul>

    <?php if ($o['status'] === 'awaiting_payment' || $o['status'] === 'rejected'): ?>
      <?php if ($o['status'] === 'rejected'): ?>
        <div class="notice bad">Your screenshot was unclear. Please upload it again.</div>
      <?php endif; ?>
      <form action="process.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="action" value="pay">
        <input type="hidden" name="order_id" value="<?= $o['id'] ?>">
        <label>How will you pay?</label>
        <select name="method" onchange="document.getElementById('g<?= $o['id'] ?>').style.display = this.value == 'gcash' ? 'block' : 'none'">
          <option value="counter">Pay at the counter</option>
          <option value="gcash">GCash QR</option>
        </select>
        <div id="g<?= $o['id'] ?>" style="display:none">
          <p>Scan this QR in the GCash app, pay <strong><?= peso($o['total']) ?></strong>, then upload your screenshot.</p>
          <img class="proof" src="assets/images/gcash_qr.png" alt="Café GCash QR" onerror="this.alt='(Put the café GCash QR at assets/images/gcash_qr.png)'">
          <input type="file" name="proof" accept="image/*">
        </div>
        <button class="btn" type="submit">Submit payment</button>
      </form>

    <?php elseif ($o['status'] === 'pending'): ?>
      <div class="notice">Waiting for staff to confirm your payment.</div>

    <?php else: ?>
      <div>Queue number</div>
      <div class="queue">#<?= (int)$o['id'] ?></div>
      <div class="steps">
        <?php for ($n = 1; $n <= 4; $n++): ?>
          <div class="<?= $steps[$o['status']] >= $n ? 'on' : '' ?>"></div>
        <?php endfor; ?>
      </div>
      <span class="tag"><?= e($o['status'] === 'queued' ? 'In queue' : ucfirst($o['status'])) ?></span>
    <?php endif; ?>
    <?php if ($o['status'] !== 'completed'): ?>
      <p><a class="btn small alt" href="?demo_next=<?= $o['id'] ?>">Demo: next status</a></p>
    <?php endif; ?>
  </div>

  <?php if ($o['status'] === 'completed' && !$o['reviewed']): ?>
  <div class="modal"><div class="box">
    <h3>How was your order #<?= $o['id'] ?>?</h3>
    <form action="process.php" method="post" enctype="multipart/form-data">
      <input type="hidden" name="action" value="review">
      <input type="hidden" name="order_id" value="<?= $o['id'] ?>">
      <div class="stars">
        <?php for ($s = 5; $s >= 1; $s--): ?>
          <label><input type="radio" name="rating" value="<?= $s ?>" <?= $s == 5 ? 'checked' : '' ?>> <?= $s ?>★</label>
        <?php endfor; ?>
      </div>
      <textarea name="comment" rows="3" placeholder="Tell us what you think"></textarea>
      <input type="file" name="photo" accept="image/*" >
      <button class="btn" type="submit">Send review</button>
    </form>
  </div></div>
  <?php endif; ?>
<?php endforeach; ?>

<?php include 'includes/footer.php'; ?>
