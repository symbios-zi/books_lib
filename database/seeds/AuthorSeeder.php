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
        factory(App\Author::class, 150)->create()->each(function ($author) {
            $author->books()->saveMany(factory(App\Book::class, 5)->make());
            $author->cds()->saveMany(factory(App\Cd::class, 3)->make());

        });
    }
}
