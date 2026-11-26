<?php
view('auth/login.view.php', [
	'head_title' => 'Login',
	'errors' => $_SESSION['_temp']['errors'] ?? []
]);
