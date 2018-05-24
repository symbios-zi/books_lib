<?php

namespace App\Services\FiltersService;

use Illuminate\Database\Eloquent\Builder;

class BooksFilters extends QueryFilters
{
    /**
     * @param $authorName
     * @return Builder
     */
    public function author_name(string $authorName)
    {
        return $this->builder->whereHas('author', function($query) use($authorName) {
           $query->where('name', 'like', "%${authorName}%");
        });
    }

    /**
     * @param string $year
     * @return Builder
     */
    public function from_year(string $year)
    {
        return $this->builder->where('year', '>=', $year);
    }

    /**
     * @param string $year
     * @return Builder
     */
    public function to_year(string $year)
    {
        return $this->builder->where('year', '<=', $year);
    }

}