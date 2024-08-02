<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Renderer\TemplateRenderer;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class HomeController
{
    private array $bookList;
    
    public function __construct(private TemplateRenderer $renderer) 
    {
        $data = file_get_contents(dirname(__DIR__, 2) . '/data/data.json');
        $this->bookList = json_decode($data, true);
    }

    public function index(Request $request, Response $response): Response
    {
        $viewData = [
            'title' => 'My Reading List',
        ];

        return $this->renderer->render($response, 'index.tpl', $viewData); 
    }

    public function getBookList(Request $request, Response $response): Response
    {

        $viewData = [
            'title' => 'My Reading List',
            'books' => $this->bookList
        ];

        return $this->renderer->render($response, 'list.tpl', $viewData);
    }

    public function getBook(Request $request, Response $response): Response
    {
        $id = $request->getAttribute('id');

        foreach($this->bookList as $bookId => $book) {
            if ($book['id'] === $id) {
                $viewData = [
                    'book' => $book
                ];
                break;
            }
        }

        return $this->renderer->render($response, 'details.tpl', $viewData);
    }

    public function create(Request $request, Response $response): Response
    {
        $newBook = $request->getParsedBody();
        $newBook['id'] = trim(uniqid());
        
        $this->bookList[] = $newBook;

        file_put_contents(dirname(__DIR__, 2) . '/data/data.json', json_encode($this->bookList));

        return $response
            ->withHeader('Location', "/books/{$newBook['id']}")
            ->withStatus(302);
    }

    public function edit(Request $request, Response $response): Response
    {
        $id = $request->getAttribute('id');

        foreach($this->bookList as $book) {
            if ($book['id'] === $id) {
                $viewData = [
                    'book' => $book
                ];
                break;
            }
        }

        return $this->renderer->render($response, 'edit.tpl', $viewData);
    }

    public function update(Request $request, Response $response): Response
    {
        $id = $request->getAttribute('id');
        $updatedBook = $request->getParsedBody();
        $updatedBook['id'] = $id;

        foreach($this->bookList as $bookId => $book) {
            if ($book['id'] === $id) {
                $this->bookList[$bookId] = $updatedBook;
                break;
            }
        }

        file_put_contents(dirname(__DIR__, 2). '/data/data.json', json_encode($this->bookList));

        return $this->renderer->render($response, 'details.tpl', ['book' => $updatedBook]);
    }

    public function destroy(Request $request, Response $response): Response
    {
        $id = $request->getAttribute('id');

        foreach($this->bookList as $bookId => $book) {
            if ($book['id'] === $id) {
                unset($this->bookList[$bookId]);
                break;
            }
        }
        
        file_put_contents(dirname(__DIR__, 2). '/data/data.json', json_encode($this->bookList));

        return $response;
    }

    public function find(Request $request, Response $response): Response
    {
        $searchTerm = strtolower(trim($request->getParsedBody()['search'], ' '));

        $filteredBooks = array_filter($this->bookList, function($book) use ($searchTerm) {
            return stripos(strtolower($book['title']), $searchTerm) !== false
                || stripos(strtolower($book['author']), $searchTerm) !== false;
        });

        // var_dump($filteredBooks);
        // die();

        return $this->renderer->render($response, 'list.tpl', ['books' => $filteredBooks]);
    }
}