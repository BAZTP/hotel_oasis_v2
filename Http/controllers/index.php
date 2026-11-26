<?php
$services = [
	[
		'name' => 'Servicios',
		// 'description' => 'Inovacion',
		'path' => '/servicios',
		'svg' => 'servicios.php'
		// 'image' => 'https://cdn-user-icons.flaticon.com/106807/106807565/1718596546537.svg?token=exp=1718597457~hmac=318e1044cab48256f93a24d37371539a'
	],
	[
		'name' => 'Promociones',
		// 'description' => 'Algo',
		'path' => '/promociones',
		'svg' => 'Promociones.php'
		// 'image' => 'https://cdn-user-icons.flaticon.com/106807/106807565/1718596586264.svg?token=exp=1718605865~hmac=d2d048de59d24c60e42c16d62d887611'
	],
	[
		'name' => 'Reservaciones',
		// 'description' => 'y si',
		'path' => '/reservas',
		'svg' => 'reservaciones.php'
		// 'image' => 'https://cdn-user-icons.flaticon.com/106807/106807565/1718596143203.svg?token=exp=1718597457~hmac=95973328891ae635f5622606395edc42'
	]
];

view('index.view.php', [
	'head_title' => 'Inicio',
	'services' => $services
]);
