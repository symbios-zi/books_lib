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
     * BookService constructor.
     * @param Book $bookModel
     */
    public function __construct(Book $bookModel)
    {
        $this->bookModel = $bookModel;
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
        $author = Author::firstOrCreate(['name' => $fields['author_name']]);

        $book = new Book();
        $book->fill($fields);
        $book->author()->associate($author);
        $book->save();

        return $book;
    }
}