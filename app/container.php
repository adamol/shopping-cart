<?php


use Slim\Views\Twig;
use Acme\Basket\Basket;
use Acme\Models\Product;
use Slim\Views\TwigExtension;
use Acme\Support\Storage\SessionStorage;
use Acme\Support\Storage\Contracts\StorageInterface;
use Interop\Container\ContainerInterface;
use Acme\Validation\Contracts\ValidatorInterface;
use Acme\Validation\Validator;

use function DI\get;

return [
	'router' => get(Slim\Router::class),
	ValidatorInterface::class => function(ContainerInterface $c) {
		return new Validator;
	},
	StorageInterface::class => function(ContainerInterface $c) {
		return new SessionStorage('cart');
	},
	Twig::class => function(ContainerInterface $c) {
		$twig = new Twig(__DIR__ . '/../resources/views', [
			'cache' => false
		]);

		$twig->addExtension(new TwigExtension(
			$c->get('router'),
			$c->get('request')->getUri()
		));

		$twig->getEnvironment()->addGlobal('basket', $c->get(Basket::class));

		return $twig;
	},
	Product::class => function(ContainerInterface $c) {
		return new Product;
	},
	Basket::class => function(ContainerInterface $c) {
		return new Basket(
			$c->get(SessionStorage::class),
			$c->get(Product::class)
		);
	},
];