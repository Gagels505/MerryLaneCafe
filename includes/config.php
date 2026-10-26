<?php


// Folder name of the project inside C:\xampp\htdocs\
define('BASE_URL', '/MerryLaneCafe');

session_start();

date_default_timezone_set('Asia/Manila');

define('OPEN_TIME', '08:00');
define('CLOSE_TIME', '20:00');
define('LAST_ORDER_TIME', '19:30');

function e($s) {
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

function peso($n) {
    return '₱' . number_format((float)$n, 2);
}


function sample_menu() {
    return [
        ['id' => 1, 'name' => 'Iced Spanish Latte', 'category' => 'Coffee',   'price' => 180, 'desc' => 'Espresso, milk, a sweet little lift', 'stock' => 'available'],
        ['id' => 2, 'name' => 'Almond Croissant',   'category' => 'Pastries', 'price' => 140, 'desc' => 'Buttery layers, toasted almonds',     'stock' => 'few'],
        ['id' => 3, 'name' => 'Basque Cheesecake',  'category' => 'Pastries', 'price' => 190, 'desc' => 'Creamy center, caramelized top',      'stock' => 'out'],
        ['id' => 4, 'name' => 'Pesto Chicken Toast','category' => 'Meals',    'price' => 240, 'desc' => 'Basil pesto on toasted sourdough',    'stock' => 'few'],
        ['id' => 5, 'name' => 'Americano',          'category' => 'Coffee',   'price' => 100, 'desc' => 'Bold and clean',                      'stock' => 'available'],
    ];
}

function my_orders() {
    return $_SESSION['orders'] ?? [];
}
