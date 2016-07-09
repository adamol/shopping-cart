<?php

namespace Acme\Controllers;

use Slim\Router;
use Slim\Views\Twig;
use Acme\Models\Product;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ProductController
{

	public function get($slug, Product $product, Request $request, Response $response, Twig $view, Router $router)
	{
		$product = $product->where('slug', $slug)->first();

		if (!$product) {
			return $response->withRedirect($router->pathFor('home'));
		}

		return $view->render($response, 'products/product.twig', [
			'product' => $product
		]);
	}
}