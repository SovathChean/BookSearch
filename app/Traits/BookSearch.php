<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait BookSearch
{
    public function removeStopWord($input)
    {
        $stopWords = [
            "i", "--", '-', "me", "my", "myself", 'i', 'i\'d', 'ie', 'if', 'i\'ll', 'i\'m', "we", "our", "ours", "ourselves", "you", "your", "yours", "yourself",
            "yourselves", "he", "him", "his", "himself", "she", "her", "hers", "herself", "it", "its", "itself", "they",
            "them", "their", "theirs", "themselves", "what", "which", "who", "whom", "this", "that", "these", "those",
            "am", "is", "are", "was", "were", "be", "been", "being", "have", "has", "had", "having", "do", "does",
            "did", "doing", "a", "an", "the", "and", "but", "if", "or", "because", "as", "until", "while", "of",
            "at", "by", "for", "with", "about", "against", "between", "into", "through", "during", "before", "after",
            "above", "below", "to", "from", "up", "down", "in", "out", "on", "off", "over", "under", "again", "further",
            "then", "once", "here", "there", "when", "where", "why", "how", "all", "any", "both", "each", "few", "more",
            "most", "other", "some", "such", "no", "nor", "not", "only", "own", "same", "so", "than", "too", "very",
            "s", "t", "can", "will", "just", "don", "should", "now",
            'he', 'he\'d', 'he\'ll',
        ];

        $input = preg_replace('/\b(' . implode('|', $stopWords) . ')\b/', '', $input);
        $input = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $input)));

        return $input;
    }
    public function wordCount($sentence)
    {
        $words = $this->removeStopWord($sentence);

        return array_count_values(str_word_count($words, 1));
    }
    public function filterJson()
    {
        $books = $this->readJsonFile();
        $filterTitle = [];
        foreach($books as $book)
        {
            $newBook = [];
            if(isset($book['description']) && isset($book['authors'])
             && isset($book['pageCount']) && isset($book['title']) && isset($book['id']))
             {
                $newBook['id'] = $book['id'];
                $newBook['title'] = $book['title'];
                $newBook['description'] = $book['description'];
                $newBook['authors'] = array_values($book['authors'])[0];
                $newBook['pageCount'] = $book['pageCount'];
                
                $filterTitle[] = $newBook;
             }

        }
        return $filterTitle;
    }
    public function tf($input)
    {
        $words = $this->wordCount($input);
        $tf = [];
        foreach ($words as $word => $val) {
            $tf[$word] =  number_format((1 + log($val, 2)), 4);
        }
        return $tf;
    }
    public function totalFreq($words)
    {
        $title = '';
        foreach ($words as $word) {

            $title = strtolower($title . ' ' . $word['title']);
        }

        return  $this->wordCount($title);
    }
    public function idf($input)
    {
        $freq = $this->totalFreq($input);
        $idf = [];
        foreach ($freq as $f => $val) {
            $idf[$f] = number_format(log(count($freq) / $val, 2));
        }
        return $idf;
    }
    public function tf_idf($books, $str_type)
    {
        $newBook = [];
        $type = ["title", "description", "authors"];
        $totalFreq = $this->totalFreq($books);
        foreach ($books as $book) {
            $words = $this->wordCount(strtolower($book[$str_type]));
            $bb = [];
            foreach ($words as $word => $val) {
                $bb['term'] = preg_replace("/[^a-zA-Z0-9%\/\s]/", "", $word);
                $bb['doc'] = $book['id'];
                $bb['type'] = array_search($str_type, $type) + 1;
                $bb['tf'] = (1 + log($val, 2));
                if (isset($totalFreq[$word])) {
                    $bb['idf'] = log(count($totalFreq) / $totalFreq[$word], 2);
                } else {
                    $bb['idf'] = 0.00001;
                }
                $newBook[] = $bb;
            }
        }
        return $newBook;
    }
    public function readJsonFile()
    {
        $file = storage_path() . "/json/books.json";
        $json = @file_get_contents($file);
        $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
        $json = str_replace('&quot;', "\"", $json);
        $obj = json_decode($json, true);

        return $obj;
    }
    public function cosine_similarity($input, $type)
    {
        $books =  $this->readJsonFile();
        $words = $this->wordCount($input);
        $totalFreq = $this->totalFreq($books);
        $cosine_simi = [];
        $group_word = $this->relevent_doc($words, $type);
        $total_wq =  $this->total_query_weight($words, $totalFreq);

        foreach ($group_word as $docs) {
            $cosine_simi[] = $this->calculate_cosine($docs, $total_wq, $totalFreq);
        }

        return $cosine_simi;
    }
    public function calculate_cosine($docs, $total_wq, $totalFreq)
    {
        $wq = 0;
        $doc_num = '';
        $upper = 0;
        $total_wt = 0;
        $epsilon = 0.000001;
        $simi = [];
        $val = 1;

        foreach ($docs as $d) {
            $wq = 0;
            $wt = $d->tf * $d->idf;
            if (isset($totalFreq[$d->term])) {

                $wq = (1 + log($val)) * log((count($totalFreq) / $totalFreq[$d->term]), 2);
            }

            $total_wt = $total_wt + pow($wt, 2);
            $upper = $upper + ($wt * $wq);
            $doc_num = $d->doc;
        }
       
            $simi[$doc_num] = $upper / ((sqrt($total_wt) * sqrt($total_wq)) + $epsilon);
        
        return $simi;
    }
    public function relevent_doc($words, $type)
    {
        $document = [];

        foreach ($words as $word => $val) {
            $docs =   $this->get_tf_idfs($word, $type);
            
            $document = array_merge($document, $docs);
        }
        

        $group_word = $this->group_by('doc', $document);

        return $group_word;
    }
    public function get_tf_idfs(string $word, int $type)
    {
        return DB::table('tf_idfs')->where('term', $word)
                                   ->where('type', $type)
                                   ->get()->toArray();
    }
    public function total_query_weight($words, $totalFreq)
    {
        $total_wq = 0;
        foreach ($words as $word => $val) {
            $wq = 0;

            if (isset($totalFreq[$word])) {

                $wq = (1 + log($val)) * log((count($totalFreq) / $totalFreq[$word]), 2);
            }

            $total_wq = $total_wq + pow($wq, 2);
        }

        return $total_wq;
    }
    function group_by($key, $data)
    {
        $result = array();

        foreach ($data as $val) {
            $result[$val->$key][] = $val;
        }

        return $result;
    }
    public function ranking($input, $type)
    {
        $books =  $this->readJsonFile();
        $cosine_simi = $this->cosine_similarity($input, $type);
        $rankBook = [];
        foreach ($books as $book) {
            if(isset($book['description']) && isset($book['authors'])
            && isset($book['pageCount']) && isset($book['title']) && isset($book['id']))
            {
                foreach ($cosine_simi as $cosine) {
                    if (isset($cosine[$book['id']])) {
                        $newBook = [];
                        $newBook['title'] = $book['title'];
                        $newBook['description'] = $book['description'];
                        $newBook['authors'] = $book['authors'];
                        $newBook['pageCount'] = $book['pageCount'];
                        $newBook['id'] = $book['id'];
                        $newBook['simi'] = $cosine[$book['id']];
                        $rankBook[] = $newBook;
                    }
                }
            }
           
        }

        $rankBook = $this->array_sort($rankBook, 'simi', SORT_DESC);
        return $rankBook;
    }

    function array_sort($array, $on, $order = SORT_ASC)
    {
        $new_array = array();
        $sortable_array = array();

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }

            foreach ($sortable_array as $k => $v) {
                array_push($new_array, $array[$k]);
            }
        }

        return $new_array;
    }
}
