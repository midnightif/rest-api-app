<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

$app['debug'] = true;

#routes
$app->get('/', function () use( $app) {
    return "Home Page";

});

$app->get('/comment', function () use($app) {
    $comments = $app['mongo.comments']->find();

    return json_encode(iterator_to_array($comments, false), true);

});

$app->get('/comment/{id}', function ($id) use($app) {
    $comment = $app['mongo.comments']->findOne(array('_id' => $id));

    return json_encode(iterator_to_array($comment, false), true);
});

$app->post('/comment', function (Request $request) use($app) {

    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data =json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }

    $newComment = [
        '_id' => $request->request->get('_id'),
        'name' => $request->request->get('name'),
        'text' =>  $request->request->get('text'),
        'data' => $request->request->get('data'),
    ];

    $app['mongo.comments']->insertOne($newComment);
    return $app->json($newComment,201);;
});


$app->put('/comment/{id}', function ($id) use($app) {
    /* TODO this route should edit comment by id */
});

$app->delete('/comment/{id}', function ($id) use($app) {
    /* TODO this route should delete one comment by id */
});
