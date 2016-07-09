<?php

$app->get('/', ['Acme\Controllers\HomeController', 'index'])->setName('home');

$app->get('/products/{slug}', ['Acme\Controllers\ProductController', 'get'])->setName('product.get');

$app->get('/cart', ['Acme\Controllers\CartController', 'index'])->setName('cart.index');
$app->get('/cart/add/{slug}/{quantity}', ['Acme\Controllers\CartController', 'add'])->setName('cart.add');