<?php

$title   = $title ?? 'Merrylane Café';
$wide    = $wide ?? false;
$minLoad = $minLoad ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($title) ?> | Merrylane Café</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="<?= BASE_URL ?>/assets/style.css">
</head>
<body data-min-load="<?= (int)$minLoad ?>">

<div id="loader">
  <img src="<?= BASE_URL ?>/assets/images/logo.png" alt="" onerror="this.remove()">
  <p>Loading...</p>
</div>

<div class="app <?= $wide ? 'wide' : '' ?>">

<header class="topbar">
  <a class="brand" href="<?= BASE_URL ?>/index.php"><i>M</i> Merrylane Café</a>
</header>
