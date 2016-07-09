<?php

$app->get('/', ['Acme\Controllers\HomeController', 'index'])->setName('home');

$app->get('/products/{slug}', ['Acme\Controllers\ProductController', 'get'])->setName('product.get');