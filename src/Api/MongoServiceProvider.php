<?php
namespace Api;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class MongoServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app )
    {
        $app['mongo'] = function() {
            return new \MongoDB\Client;
        };

        $app['mongo.comments'] = function($app) {
            $comments = $app['mongo']->api->comments;
            return $comments;
        };
    }
    public function boot(Container $app)
    {
    }
}