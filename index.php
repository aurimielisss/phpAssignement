<?php
require 'Slim/Slim.php';
require_once "config/config.inc.php";
require_once "mappingMidlleware.php";
\Slim\Slim::registerAutoloader();
// $app = new \Slim\Slim();

$app = new customSlim();

$app->group('/api', function () use ($app) {
	
	$app->customMap("/users(/:id)", 'UserModel', 'UserController');
	$app->customMap("/category(/:id)", 'CategoryModel', 'CategoryController');
	
});

$app->run();

