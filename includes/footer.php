<?php

$nav = $nav ?? true;
?>
<?php if ($nav):
  
  $here = basename($_SERVER['SCRIPT_NAME']);
?>
->
<nav class="bottom-nav">
  <a class="<?= $here === 'menu.php' ? 'on' : '' ?>" href="<?= BASE_URL ?>/menu.php">
    <svg viewBox="0 0 24 24"><path d="M4 8h13v6a5 5 0 0 1-5 5H9a5 5 0 0 1-5-5V8z"/><path d="M17 10h2a2 2 0 0 1 0 4h-2M8 3v2M12 3v2"/></svg>
    Menu
  </a>
  <a class="<?= $here === 'orders.php' ? 'on' : '' ?>" href="<?= BASE_URL ?>/orders.php">
    <svg viewBox="0 0 24 24"><path d="M6 3h12v18l-3-2-3 2-3-2-3 2V3z"/><path d="M9 8h6M9 12h6"/></svg>
    My order
  </a>
  <a class="<?= $here === 'waiter.php' ? 'on' : '' ?>" href="<?= BASE_URL ?>/waiter.php">
    <svg viewBox="0 0 24 24"><path d="M6 17V11a6 6 0 0 1 12 0v6l1.5 2h-15L6 17z"/><path d="M10 21h4"/></svg>
    Call waiter
  </a>
</nav>
<?php endif; ?>
</div>
<script src="<?= BASE_URL ?>/assets/script.js"></script>
</body>
</html>
