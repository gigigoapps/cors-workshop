<?php

require_once __DIR__.'/../../vendor/autoload.php';

use Symfony\Component\HttpFoundation\JsonResponse;

$app = new Silex\Application();

/**
 * Api Homepage
 */
$app->get('/', function() use($app) {
    return <<<HTML

<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
function getAjaxData() {
  $.get('http://localhost:8081/api', function(response) {
    console.log(response);
  }, 'json');
}
</script>

<h1>Welcome to API</h1>
<a href="javascript:getAjaxData()">call to api with ajax</a>

HTML;
});

/**
 * Some api endpoint
 */
$app->get('/api', function() use($app) {
    return JsonResponse::create(['title' => 'Cors', 'type' => 'WorkShop']);
});

$app->run();