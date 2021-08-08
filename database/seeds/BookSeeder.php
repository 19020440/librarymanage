<?php

use App\Models\Book;
use App\Models\Content;
use App\Models\Image;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $arrImg = ['images/book1.jpg', 'images/book2.jpg', 'images/book3.jpg'];

        $books = factory(Book::class, 100)->create();

        foreach ($books as $book) {
            Image::insert([
                'book_id' => $book->id,
                'type_face' => 0,
                'path' => $faker->randomElement($arrImg),
            ]);
            Image::insert([
                'book_id' => $book->id,
                'type_face' => 1,
                'path' => $faker->randomElement($arrImg),
            ]);
            Content::insert([
                'book_id' => $book->id,
                'content_book' => $faker->paragraph()
            ]);
        }
        return;
    }
}
