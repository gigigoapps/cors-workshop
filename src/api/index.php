<?php

require_once __DIR__.'/../../vendor/autoload.php';

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application();

/**
 * Api Homepage
 */
$app->get('/', function() use($app) {
    return <<<HTML

<h1>Welcome to API</h1>

HTML;
});

/**
 * before each request check options and heders
 */
$app->before(function(Request $request) use( $app) {
    if ($request->getMethod() == 'OPTIONS') {
        $origin = '*';

        return new Response('', 200, [
            'Access-Control-Allow-Origin' => $origin
        ]);
    }
}, Silex\Application::EARLY_EVENT);

/**
 * After request will be sent to client, set cors headers
 */
$app->after(function(Request $request, Response $response) use ($app) {
    $origin = '*';

    $response->headers->add([
        'Access-Control-Allow-Origin' => $origin
    ]);
});

/**
 * Some api endpoint
 */
$app->match('/api', function(Request $request) use($app) {
    return JsonResponse::create([
        'title' => 'Cors (' . $request->getMethod() . ')',
        'type' => 'WorkShop'
    ]);
})
->method('GET|POST|PUT');

$app->run();