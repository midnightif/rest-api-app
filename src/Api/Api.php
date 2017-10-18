<?php
namespace Api;

use Silex\Application;
use Silex\Provider\RoutingServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Api\MongoServiceProvider;


$app = new Application();
$app['debug'] = true;
$app->register(new RoutingServiceProvider());
$app->register(new ValidatorServiceProvider());
$app->register(new ServiceControllerServiceProvider());
$app->register(new MongoServiceProvider());

return $app;
