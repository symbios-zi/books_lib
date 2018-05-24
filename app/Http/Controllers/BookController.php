<?php

namespace App\Http\Controllers;

use App\Services\BookService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\BookAddRequest;
use App\Services\FiltersService\BooksFilters;

class BookController extends Controller
{

    /**
     * @var BookService
     */
    private $bookService;

    /**
     * BookController constructor.
     * @param BookService $bookService
     */
    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function index(BooksFilters $booksFilters): JsonResponse
    {
        $books = $this->bookService->search($booksFilters);

        return new JsonResponse($books);
    }

    public function store(BookAddRequest $request): JsonResponse
    {
        $fields = $request->all();
        $createdBook = $this->bookService->add($fields);

        return new JsonResponse([
            'id' => $createdBook->id,
            'success' => true
        ], 201);
    }
}
