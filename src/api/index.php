<?php

require_once __DIR__.'/../../vendor/autoload.php';

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application();

/**
 * Register session
 */
$app->register(new Silex\Provider\SessionServiceProvider());

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

            'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE',
            'Access-Control-Allow-Headers' => 'X-app-version',
            'Access-Control-Max-Age' => 86400
        ]);
    }
}, Silex\Application::EARLY_EVENT);

/**
 * After request will be sent to client, set cors headers
 */
$app->after(function(Request $request, Response $response) use ($app) {
    //$origin = '*';
    $origin = $request->headers->get('origin');

    $response->headers->add([
        'Access-Control-Allow-Origin' => $origin,
        'Access-Control-Allow-Credentials' => 'true'
    ]);
});

/**
 * Some api endpoint
 */
$app->match('/api', function(Request $request) use($app) {

    // TODO check this response, activating and deactivating withCredentials in browser

    if (null === $firstAccessTime = $app['session']->get('firstAccessTime')) {
        $firstAccessTime = (new \DateTime())->format(DATE_ISO8601);
        $app['session']->set('firstAccessTime', $firstAccessTime);
    }

    return JsonResponse::create([
        'title' => 'Cors (' . $request->getMethod() . ')',
        'type' => 'WorkShop',
        'version' => $request->headers->get('X-app-version'),
        'firstTimeAccess' => $firstAccessTime
    ]);
})
->method('GET|POST|PUT');

$app->run();