<?php
function base_path($path): string
{
	return BASE_PATH . $path;
}

function abort($code = 404)
{
	http_response_code($code);
	require base_path("views/{$code}.php");

	die();
}

function view($path, $attributes = []): void
{
	extract($attributes);

	require base_path('views/' . $path);
}

function redirect($path)
{
	header("Location: {$path}");
	exit();
}
