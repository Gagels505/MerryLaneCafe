<?php

require 'includes/config.php';

$action = $_POST['action'] ?? '';


function back($url) {
    header('Location: ' . BASE_URL . '/' . $url);
    exit;
}

if ($action === 'start') {
    $_SESSION['order_type'] = ($_POST['order_type'] ?? '') === 'take-out' ? 'take-out' : 'dine-in';
    back('menu.php');
}

if ($action === 'place') {
    $menu = sample_menu();
    $items = [];
    $total = 0;

    foreach (($_POST['qty'] ?? []) as $id => $qty) {
        $qty = (int)$qty;
        if ($qty < 1) continue;          
        foreach ($menu as $m) {
            if ($m['id'] == $id && $m['stock'] !== 'out') {
                $items[] = ['name' => $m['name'], 'qty' => $qty, 'price' => $m['price']];
                $total += $m['price'] * $qty;
            }
        }
    }

    if (!$items) back('menu.php?err=' . urlencode('Please choose at least one item.'));


    $id = count(my_orders()) + 1;
    $_SESSION['orders'][$id] = [
        'id'       => $id,
        'table'    => $_SESSION['table'] ?? '01',
        'type'     => $_SESSION['order_type'] ?? 'dine-in',
        'items'    => $items,
        'total'    => $total,
        'method'   => null,
        'status'   => 'awaiting_payment',  
        'reviewed' => false,
    ];
    back('orders.php');
}

/* ---------- pay: counter or GCash ---------- */
if ($action === 'pay') {
    $id = (int)($_POST['order_id'] ?? 0);
    if (isset($_SESSION['orders'][$id])) {
        $_SESSION['orders'][$id]['method'] = ($_POST['method'] ?? '') === 'gcash' ? 'gcash' : 'counter';
        $_SESSION['orders'][$id]['status'] = 'pending';
    }
    back('orders.php');
}

if ($action === 'review') {
    $id = (int)($_POST['order_id'] ?? 0);
    if (isset($_SESSION['orders'][$id])) {
        $_SESSION['orders'][$id]['reviewed'] = true;
    }
    back('orders.php?thanks=1');
}

if ($action === 'waiter') {
    back('waiter.php?sent=1');
}

back('index.php');  
