<?php
view('auth/register.view.php', [
	'head_title' => 'Register',
	'errors' => $_SESSION['_temp']['errors'] ?? []
]);
