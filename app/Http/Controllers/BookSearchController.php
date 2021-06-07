<?php

namespace App\Http\Controllers;


use App\Traits\BookSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookSearchController extends Controller
{
    use BookSearch;

    public function results(Request $request)
    {
        $data = $request->validate([
            "query" => ["required", "string", "max:255"]
        ]);
        $time_start = microtime(true);
        $input = strtolower($data['query']);
        $books = $this->ranking($input);
        $time_end = microtime(true);
        $total_time = ($time_end - $time_start) / 1000000;
       
        return response()->json([
            'data'=> $books,
            'total' => count($books),
            'time_spend' => $total_time
        ]);
    }

}
