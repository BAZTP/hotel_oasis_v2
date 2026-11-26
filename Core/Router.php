<?php
namespace Core;

use Core\Middleware\Middleware;

class Router
{
	protected array $routes = [];

	public function add($method, $uri, $controller): Router
	{
		$this->routes[] = [
			'uri' => $uri,
			'controller' => $controller,
			'method' => $method,
			'middleware' => null
		];

		return $this;
	}

	public function get($uri, $controller): Router
	{
		return $this->add('GET', $uri, $controller);
	}

	public function post($uri, $controller): Router
	{
		return $this->add('POST', $uri, $controller);
	}

	public function put($uri, $controller): Router
	{
		return $this->add('PUT', $uri, $controller);
	}

	public function delete($uri, $controller): Router
	{
		return $this->add('DELETE', $uri, $controller);
	}

	public function middleware($middleware): static
	{
		$this->routes[count($this->routes) - 1]['middleware'] = $middleware;

		return $this;
	}

	public function route($uri, $method)
	{
		foreach ($this->routes as $route) {
			// Match route if it has an extra / at the end
			if ($route['uri'] === $uri || $route['uri'] . '/' === $uri) {
				if ($route['method'] === $method) {
					Middleware::handle($route['middleware']);
					return require base_path("Http/controllers/{$route['controller']}");
				}
			}
		}

		$this->abort();
	}

	public function previousUrl()
	{
		return $_SERVER['HTTP_REFERER'];
	}

	protected function abort($code = 404)
	{
		http_response_code($code);

		require base_path("views/{$code}.php");

		die();
	}
}
