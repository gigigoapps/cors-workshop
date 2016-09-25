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
function getAjaxData() {
  $.get('http://localhost:8081/api', function(response) {
    console.log(response);
  }, 'json');
}
</script>
        
<h1>Welcome to Dashbard</h1>
<a href="javascript:getAjaxData()">call to api with ajax</a>

HTML;
});

$app->run();