<?php

require_once __DIR__.'/../../vendor/autoload.php';

$app = new Silex\Application();

/**
 * Dashboard Homepage
 */
$app->get('/', function() use($app) {
    return <<<HTML
    
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
function ajaxData(method) {
  $.ajax({
    url: 'http://localhost:8081/api',
    method: method,
    headers: {
        'X-app-version': '1.0.0-RC'
    }
  }).done(function(data) {
    console.log(data);
  });
}
</script>
        
<h1>Welcome to Dashbard</h1>
<ul>
<li><a href="javascript:ajaxData('GET')">GET call to api with ajax</a></li>
<li><a href="javascript:ajaxData('POST')">POST call to api with ajax</a></li>
<li><a href="javascript:ajaxData('PUT')">PUT call to api with ajax</a></li>
</ul>

HTML;
});

$app->run();