<?php
$routes = [
	['name' => 'Inicio', 'path' => '/'],
	['name' => 'Reservas', 'path' => '/reservas'],
	['name' => 'Servicios', 'path' => '/servicios'],
	['name' => 'Promociones', 'path' => '/promociones'],
	['name' => 'Contacto', 'path' => '/contacto']
];
$currentPath = $_SERVER['REQUEST_URI'];
?>

<header class="relative bg-primary-950 flex items-center justify-between h-20 px-8 border-b-4 border-b-accent-700">
  <a href="/" class="flex items-center gap-x-2 relative h-full">
    <img class="h-full w-auto aspect-square" src="/images/logo.png" alt="Logo Hotel Oasis">
    <h1 class="text-3xl font-bold text-text-100">Hotel Oasis</h1>
  </a>
  <nav class="hidden md:flex items-center gap-x-4 text-text-100 h-full relative font-wix">
    <?php foreach ($routes as $route): ?>
      <a href="<?= $route[
      	'path'
      ] ?>" class="border-b-2 py-0.5 transition duration-200 hover:border-b-accent-700 <?= $currentPath ===
$route['path']
	? 'font-bold border-b-accent-700'
	: 'border-b-transparent' ?>"><?= $route['name'] ?></a>
    <?php endforeach; ?>
  </nav>
</header>