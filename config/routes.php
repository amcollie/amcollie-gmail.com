<?php

declare(strict_types = 1);

use App\Controllers\HomeController;
use Slim\App;

return function (App $app): void {
    $app->get('/', [HomeController::class, 'index']);
    $app->get('/books', [HomeController::class, 'getBookList']);
    $app->post('/books', [HomeController::class, 'create']);
    $app->post('/books/search', [HomeController::class, 'find']);
    $app->get('/books/{id}', [HomeController::class, 'getBook']);
    $app->get('/books/edit/{id}', [HomeController::class, 'edit']);
    $app->put('/books/{id}', [HomeController::class, 'update']);
    $app->delete('/books/{id}', [HomeController::class,'destroy']);
};