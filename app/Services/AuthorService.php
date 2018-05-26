<?php

namespace App\Services;

use App\Book;
use App\Author;
use Illuminate\Support\Collection;

class AuthorService
{
    /**
     * @var Author
     */
    private $authorModel;

    /**
     * @var Book
     */
    private $bookModel;

    public function __construct(Author $authorModel, Book $bookModel)
    {
        $this->authorModel = $authorModel;
        $this->bookModel = $bookModel;
    }

    /**
     * Returns top authors by books count
     * @return Collection
     */
    public function top(): Collection
    {
        return $this->authorModel
            ->select('name')
            ->withCount('books')
            ->orderBy('books_count', 'desc')
            ->get();
    }

    public function collectAverageByYearFor($name)
    {
        $authorWithCountOfBooks = $this->authorModel
            ->withCount('books')
            ->where('name', 'like', "%$name%")
            ->firstOrFail();

        $yearsList = $this->bookModel
            ->select('year as name')
            ->distinct('year')
            ->get();

        $average = $this->calculateAverage($authorWithCountOfBooks, $yearsList);

        return $this->collect($yearsList, $name, $average);
    }

    /**
     * @param $yearsList
     * @param $name
     * @param $average
     * @return Collection
     */
    private function collect($yearsList, $name, $average): Collection
    {
        $years = new Collection();

        $rate = [
            'name' => $name,
            'average' => $average
        ];

        foreach ($yearsList as $yearItem) {
            $years->put($yearItem->name, $rate);
        }

        return $years;
    }

    /**
     * @param $authorWithCountOfBooks
     * @param $yearsList
     * @return float
     */
    private function calculateAverage($authorWithCountOfBooks, $yearsList): float
    {
        return $authorWithCountOfBooks->books_count / count($yearsList);
    }
}