<?php
use Core\ValidationException;
use Core\Router;
use Core\Session;
use Dotenv\Dotenv;

const BASE_PATH = __DIR__ . '/../';

session_start();

require BASE_PATH . 'vendor/autoload.php';

$LOAD_ENV_DIR = str_contains($_SERVER['HTTP_HOST'], 'localhost') ? '/../' : '/../';
$dotenv = Dotenv::createImmutable(__DIR__ . $LOAD_ENV_DIR);
$dotenv->safeLoad();

require BASE_PATH . 'Core/functions.php';
require BASE_PATH . 'bootstrap.php';

$router = new Router();
require BASE_PATH . 'routes.php';

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

try {
	$router->route($uri, $method);
} catch (ValidationException $exception) {
	Session::temp('errors', $exception->errors);
	Session::temp('old', $exception->old);
	Session::temp('success', $exception->success);
	return redirect($router->previousUrl());
}

Session::clearTemp();
