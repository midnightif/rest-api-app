<?php
define('ROOT',dirname(__DIR__));
define('DBSERVER', 'localhost' );
define('DBNAME', 'api' );

$loader = require "/../vendor/autoload.php";

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

$app = new Application();
$app['debug'] = true;

$app['config.server'] = DBSERVER;
$app['config.database'] = DBNAME;
$app['config.mongo'] = $app->share(
    function($app) {
        return new MongoClient($app['config.server']);
    }
);

#routes
$app->get('/', function () use( $app) {
return "Home Page";
});

$app->get('/comment',
function () use($app) {
    $db = $app['config.mongo']->selectDB($app['config.database']);
    $comments = new MongoCollection($db, 'comments');
    $result = $comments->find();

    $response = "[";
    foreach ($result as $comment){
        $response .= json_encode($comment);
        if( $result->hasNext()){ $response .= ","; }
    }
    $response .= "]";

    return $app->json(json_decode($response));

});

$app->get('/comment/{id}',
function ($id) use($app) {/* TODO this route should give us one comment by id */  });

$app->post('/comment',
function (Request $request) use($app) {/* TODO this route should write comment to DB */  });

$app->put('/comment/{id}',
function ($id) use($app) {/* TODO this route should edit comment by id */  });

$app->delete('/comment/{id}',
function ($id) use($app) {/* TODO this route should delete one comment by id */  });

return $app;
