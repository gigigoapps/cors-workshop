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
        return new Response('', 200, [
            /* ORIGIN WILL BE ADDED IN AFTER LISTENER */

            // 1 Resolve PUT method by adding in header
            'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE',
            // 2 Resolve custom headers by adding in header
            'Access-Control-Allow-Headers' => 'X-app-version',
            // 3 cache OPTIONS request
            'Access-Control-Max-Age' => 86400
            // 4 Play with browser cache and remove PUT from valid methods to see behavior
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
        'type' => 'WorkShop',
        'version' => $request->headers->get('X-app-version')
    ]);
})
->method('GET|POST|PUT');

$app->run();