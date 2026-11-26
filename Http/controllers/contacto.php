<?php
view('contacto.view.php', [
	'head_title' => 'Contacto',
	'errors' => $_SESSION['errors'] ?? [],
	'success' => $_SESSION['success'] ?? ''
]);
