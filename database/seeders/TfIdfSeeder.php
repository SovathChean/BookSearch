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

        $books = $this->tf_idf($this->readJsonFile());
        // dd($books);
        foreach($books as $book)
        {
            DB::table('tf_idfs')->insert([
                $book
            ]);
        }
    }
}
