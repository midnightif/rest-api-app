<?php
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;


$app = new Application();
$app['debug'] = true;

$app->get('/', function () use($app) {
    return "Home Page";
});

$app->get('/comment',
    function () use($app) { /* TODO this route should give us list of all comments */ });

$app->get('/comment/{id}',
    function ($id) use($app) {/* TODO this route should give us one comment by id */  });

$app->post('/comment',
    function (Request $request) use($app) {/* TODO this route should write comment to DB */  });

$app->put('/comment/{id}',
    function ($id) use($app) {/* TODO this route should edit comment by id */  });

$app->delete('/comment/{id}',
    function ($id) use($app) {/* TODO this route should delete one comment by id */  });

$app->run();