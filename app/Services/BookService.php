<?php

namespace App\Services;


use App\Author;
use App\Book;
use App\Services\FiltersService\BooksFilters;
use Illuminate\Database\Connection;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Collection;
use Mockery\Exception;

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
     * @var DatabaseManager
     */
    private $databaseManager;

    /**
     * BookService constructor.
     * @param Book $bookModel
     * @param LoggerService $loggerService
     * @param Author $authorModel
     * @param Connection $databaseManager
     */
    public function __construct(
        Book $bookModel,
        LoggerService $loggerService,
        Author $authorModel,
        Connection $databaseManager
    ) {
        $this->bookModel = $bookModel;
        $this->loggerService = $loggerService;
        $this->authorModel = $authorModel;
        $this->databaseManager = $databaseManager;
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
    public function add($fields)
    {
        try {
            $this->databaseManager->beginTransaction();

            if(empty($fields['author_name'])) {
                throw new \Exception('author_name field is required.');
            }

            $author = $this->authorModel->firstOrCreate(['name' => $fields['author_name']]);

            $book = new Book();
            $book->fill($fields);
            $book->author()->associate($author);
            $book->save();

            $this->loggerService->logSuccess($book, $author);

            $this->databaseManager->commit();

            return $book;
        } catch (\Exception $e) {
            $this->databaseManager->rollBack();
            throw new Exception('Item did not added');
        }

    }
}