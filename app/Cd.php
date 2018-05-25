<?php

namespace App;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed id
 */
class Cd extends Model
{
    use Filterable;

    protected $fillable = [
        'title', 'year', 'cover'
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

}
