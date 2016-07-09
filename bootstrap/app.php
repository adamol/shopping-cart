<?php

use Acme\App;
use Slim\Views\Twig;
use Illuminate\Database\Capsule\Manager as Capsule;

session_start();

require __DIR__ . '/../vendor/autoload.php';

$app = new App;

$container = $app->getContainer();

$capsule = new Capsule;
$capsule->addConnection([
	'driver' => 'mysql',
	'host' => 'localhost',
	'database' => 'shopping_cart',
	'username' => 'root',
	'password' => 'root',
	'charset' => 'utf8',
	'collation' => 'utf8_unicode_ci',
	'prefix' => ''
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

require __DIR__ . '/../app/routes.php';

$app->add(new \Acme\Middleware\ValidationErrorsMiddleware($container->get(Twig::class)));
$app->add(new \Acme\Middleware\OldInputMiddleware($container->get(Twig::class)));