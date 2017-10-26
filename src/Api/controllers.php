<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

$app['debug'] = true;

#routes
$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});

$app->get('/', function () use( $app) {
    return "Home Page";

});

$app->get('/comments', function () use($app) {
    $comments = $app['mongo.comments']->find();

    return json_encode(iterator_to_array($comments, false), true);

});

$app->get('/comments/{id}', function ($id) use($app) {
    $comment = $app['mongo.comments']->findOne(array('_id' => $id));

    return json_encode(iterator_to_array($comment, false), true);
});

$app->post('/comments', function (Request $request) use($app) {

    $newComment = [
        '_id' => $app->escape( $request->request->get('_id') ),
        'name' => $app->escape( $request->request->get('name') ),
        'text' => $app->escape( $request->request->get('text') ),
        'date' =>  $app->escape( $request->request->get('date') ),
    ];

    $app['mongo.comments']->insertOne($newComment);
    return $app->json($newComment,201);;
});

$app->put('/comments/{id}', function (Request $request, $id) use($app) {

    $updatedComment = [
        '_id' => $app->escape( $request->request->get('_id') ),
        'name' => $app->escape( $request->request->get('name') ),
        'text' => $app->escape( $request->request->get('text') ),
        'date' =>  $app->escape( $request->request->get('date') ),
    ];

    $app['mongo.comments']->updateOne(['_id' => $id], ['$set' =>  $updatedComment]);

    return $app->json($updatedComment,201);

});

$app->delete('/comments/{id}', function ($id) use($app) {
   $app['mongo.comments']->deleteOne(['_id' => $id]);

   return 'deleted';
});

$app->after(function (Request $request, Response $response) {
    $response->headers->set('Access-Control-Allow-Origin', '*');
    $response->headers->set('Access-Control-Allow-Methods', 'OPTIONS, GET, POST, PUT, DELETE');
    $response->headers->set('Allow', 'OPTIONS, GET, POST, PUT, DELETE');
    $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Access-Control-Allow-Headers, Access-Control-Allow-Methods');
});
$app->options("{anything}", function () {
    return new \Symfony\Component\HttpFoundation\JsonResponse(null, 204);
})->assert("anything", ".*");