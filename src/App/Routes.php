<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;


require __DIR__ . '/../../vendor/autoload.php';


$app->get('/', function (Request $request, Response $response, $args) { 

    $renderer = new PhpRenderer(__DIR__ . '/../Templates/');
    return $renderer->render($response, "alta.php", $args);
});
$app->get('/showUsers', function (Request $request, Response $response, $args) { 

    $renderer = new PhpRenderer(__DIR__ . '/../Templates/');
    return $renderer->render($response, "consulta.php", $args);
});

$app->post('/user', 'App\Controllers\UserController:create');
$app->get('/users', 'App\Controllers\UserController:getAllUsers');
