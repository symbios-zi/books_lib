<?php

use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Author::class, 20)->create()->each(function ($author) {
            $author->books()->save(factory(App\Book::class)->make());
        });
    }
}
