<?php

namespace Core\Middleware;

use Core\Session;

class Authenticated
{
	public function handle(): void
	{
		if (!Session::has('user') || Session::get('user')['role'] !== 'auth') {
			header('Location: /auth/login');
			exit();
		}
	}
}
