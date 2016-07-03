<?php

$app->get('/', ['Acme\Controllers\HomeController', 'index'])->setName('home');