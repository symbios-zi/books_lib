<?php

namespace Tests\Feature;

use App\Author;
use App\Book;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class AuthorTest extends TestCase
{

    use DatabaseTransactions;

    public function testFilterBooksByYear()
    {
        $author = Author::first();
        $someBook = Book::first();
        $year = $someBook->year;

        $response = $this->json('GET', "api/v1/authors/average?author_full_name=$author->name");
        $response->assertJsonFragment([$year]);
        $response->assertJsonFragment(['name' => $author->name]);

        $response->assertStatus(200);
    }
}
