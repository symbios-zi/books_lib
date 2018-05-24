<?php

namespace App;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed id
 */
class Book extends Model
{
    use Filterable;

    protected $fillable = [
        'title', 'year', 'isbn'
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function add($fields)
    {

    }
}
