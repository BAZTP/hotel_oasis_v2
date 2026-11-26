<?php

namespace Core\Middleware;

use Core\Session;

class Anon
{
	public function handle()
	{
		if (Session::has('user') && Session::get('user')['role'] === 'auth') {
			header('Location: /');
			exit();
		}
	}
}
