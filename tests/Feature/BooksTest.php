<?php

namespace Tests\Feature;

use App\Book;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class BooksTest extends TestCase
{

    use DatabaseTransactions;


    public function testGetAllBooks()
    {
        $this->json('GET', 'api/v1/books')
            ->assertStatus(200);
    }

    public function testCreatingBook()
    {
        $response = $this->json('POST', '/api/v1/books', [
            'title' => 'Super test book',
            'year' => '1984',
            'isbn' => '123013123813',
            'author_name' => 'Anton Vorontsov'
        ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'success' => true,
            ]);
    }


    public function testFilterBooksByYear()
    {
        $bookOutOfCondition = Book::where('year', '<', 2000)->first();
        $bookInCondition = Book::where([['year', '>', 2000], ['year', '<', 2010]])->first();

        $response = $this->json('GET', 'api/v1/books?from_year=2000&to_year=2010');

        $response->assertJsonMissing(['year' => $bookOutOfCondition->year]);
        $response->assertJsonFragment(['year' => $bookInCondition->year]);
        $response->assertStatus(200);
    }
}
