<?php

namespace App\Services;


use App\Author;
use App\Book;
use App\Services\FiltersService\BooksFilters;
use Illuminate\Support\Collection;

class BookService
{
    /**
     * @var Book
     */
    private $bookModel;

    /**
     * @var LoggerService
     */
    private $loggerService;
    /**
     * @var Author
     */
    private $authorModel;

    /**
     * BookService constructor.
     * @param Book $bookModel
     * @param LoggerService $loggerService
     * @param Author $authorModel
     */
    public function __construct(Book $bookModel, LoggerService $loggerService, Author $authorModel)
    {
        $this->bookModel = $bookModel;
        $this->loggerService = $loggerService;
        $this->authorModel = $authorModel;
    }

    /**
     * @param BooksFilters $filters
     * @return Collection|null
     */
    public function search(BooksFilters $filters): ?Collection
    {
        return $this->bookModel
            ->select('title', 'isbn','year', 'created_at')
            ->filter($filters)
            ->get();
    }

    /**
     * @param $fields
     * @return mixed
     */
    public function add($fields): Book
    {
        $author = $this->authorModel->firstOrCreate(['name' => $fields['author_name']]);


        $book = new Book();
        $book->fill($fields);
        $book->author()->associate($author);
        $book->save();

        $this->loggerService->logSuccess($book, $author);

        return $book;
    }
}