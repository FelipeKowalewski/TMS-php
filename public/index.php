<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Router;
use App\Controllers\TransportadoraController;
use App\Controllers\ContatoController;

header('Content-Type: application/json; charset=utf-8');

function json(mixed $data, int $status = 200): never
{
    http_response_code($status);
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

function body(): array
{
    return json_decode(file_get_contents('php://input'), true) ?? [];
}

$router = new Router();

$router->get('/transportadoras',                                [TransportadoraController::class, 'index']);
$router->get('/transportadoras/{id}',                           [TransportadoraController::class, 'show']);
$router->get('/transportadoras/{id}/contatos',                  [ContatoController::class, 'index']);
$router->get('/transportadoras/{id}/contatos/{cid}',            [ContatoController::class, 'show']);
$router->post('/transportadoras/{id}/contatos',                 [ContatoController::class, 'add']);

$router->dispatch();
