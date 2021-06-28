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
            "query" => ["required", "string", "max:255"],
            "type" => ["required", 'integer']
        ]);
        $time_start = microtime(true);
        $input = strtolower($data['query']);
        $books = $this->ranking($input, $data['type']);
        $time_end = microtime(true);
        $total_time = ($time_end - $time_start) / 1000;
       
        return response()->json([
            'data'=> $books,
            'total' => count($books),
            'time_spend' => number_format($total_time, 4)
        ]);
        // $books = DB::table('tf_idfs')->where('term', "love")
        //                            ->where('type', 2)
        //                            ->get()->toArray();
        // return response()->json($books);

    }
    public function jsonFilter()
    {
        $books = $this->jsonFilter();
        return response()->json($books);
    }

}
