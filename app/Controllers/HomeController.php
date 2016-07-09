<?php

namespace Acme\Controllers;

use Slim\Views\Twig;
use Acme\Models\Product;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HomeController
{
	public function index(Request $request, Response $response, Twig $view, Product $product)
	{
		$products = $product->get();
		var_dump($products);
		die();
		return $view->render($response, 'home.twig');
	}
}