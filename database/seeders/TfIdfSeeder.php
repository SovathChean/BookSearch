<?php

namespace Database\Seeders;

use App\Traits\BookSearch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TfIdfSeeder extends Seeder
{
    use BookSearch;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $books_title = $this->tf_idf($this->readJsonFile(), "title");
        $books_description = $this->tf_idf($this->readJsonFile(), "description");
        $books_authos = $this->tf_idf($this->readJsonFile(), "authors");
        // insert title
        foreach($books_title as $book)
        {
            DB::table('tf_idfs')->insert([
                $book
            ]);
        }
        // insert description
        foreach($books_description as $book)
        {
            DB::table('tf_idfs')->insert([
                $book
            ]);
        }
        // insert authors
        foreach($books_authos as $book)
        {
            DB::table('tf_idfs')->insert([
                $book
            ]);
        }
    }
}
