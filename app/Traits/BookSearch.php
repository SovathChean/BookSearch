<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait BookSearch
{
    public function removeStopWord($input)
    {
        // $stopWords = array('a', '-', '--', 'able', 'about', 'above', 'abroad', 'according', 'accordingly', 'across', 'actually', 'adj', 'after', 'afterwards', 'again', 'against', 'ago', 'ahead', 'ain\'t', 'all', 'allow', 'allows', 'almost', 'alone', 'along', 'alongside', 'already', 'also', 'although', 'always', 'am', 'amid', 'amidst', 'among', 'amongst', 'an', 'and', 'another', 'any', 'anybody', 'anyhow', 'anyone', 'anything', 'anyway', 'anyways', 'anywhere', 'apart', 'appear', 'appreciate', 'appropriate', 'are', 'aren\'t', 'around', 'as', 'a\'s', 'aside', 'ask', 'asking', 'associated', 'at', 'available', 'away', 'awfully', 'b', 'back', 'backward', 'backwards', 'be', 'became', 'because', 'become', 'becomes', 'becoming', 'been', 'before', 'beforehand', 'begin', 'behind', 'being', 'believe', 'below', 'beside', 'besides', 'best', 'better', 'between', 'beyond', 'both', 'brief', 'but', 'by', 'c', 'came', 'can', 'cannot', 'cant', 'can\'t', 'caption', 'cause', 'causes', 'certain', 'certainly', 'changes', 'clearly', 'c\'mon', 'co', 'co.', 'com', 'come', 'comes', 'concerning', 'consequently', 'consider', 'considering', 'contain', 'containing', 'contains', 'corresponding', 'could', 'couldn\'t', 'course', 'c\'s', 'currently', 'd', 'dare', 'daren\'t', 'definitely', 'described', 'despite', 'did', 'didn\'t', 'different', 'directly', 'do', 'does', 'doesn\'t', 'doing', 'done', 'don\'t', 'down', 'downwards', 'during', 'e', 'each', 'edu', 'eg', 'eight', 'eighty', 'either', 'else', 'elsewhere', 'end', 'ending', 
        // 'enough', 'entirely', 'especially', 'et', 'etc', 'even', 'ever', 'evermore', 'every', 
        // 'everybody', 'everyone', 'everything', 'everywhere', 'ex', 'exactly', 'example', 'except', 
        // 'f', 'fairly', 'far', 'farther', 'few', 'fewer', 'fifth', 'first', 'five', 'followed', 'following', 
        // 'follows', 'for', 'forever', 'former', 'formerly', 'forth', 'forward', 'found', 'four', 'from', 
        // 'further', 'furthermore', 'g', 'get', 'gets', 'getting', 'given', 'gives', 'go', 'goes', 'going', 
        // 'gone', 'got', 'gotten', 'greetings', 'h', 'had', 'hadn\'t', 'half', 'happens', 'hardly', 'has', 'hasn\'t', 
        // 'have', 'haven\'t', 'having', 'he', 'he\'d', 'he\'ll', 'hello', 'help', 'hence', 'her', 'here', 'hereafter', 
        // 'hereby', 'herein', 'here\'s', 'hereupon', 'hers', 'herself', 'he\'s', 'hi', 'him', 'himself', 'his', 'hither', 
        // 'hopefully', 'how', 'howbeit', 'however', 'hundred', 'i', 'i\'d', 'ie', 'if', 'i\'ll', 'i\'m', 
        // 'immediate', 'in', 'inasmuch', 'inc', 'inc.', 'inner', 'inside', 
        // 'insofar', 'instead', 'into', 'inward', 'is', 'isn\'t', 'it', 'it\'d', 'it\'ll', 'its', 'it\'s', 'itself', 
        // 'i\'ve', 'j', 'just', 'k', 'keep', 'keeps', 'kept', 'know', 'known', 'knows', 'l', 'last', 'lately', 'later', 'latter', 'latterly', 'least', 'less', 'lest', 'let', 'let\'s', 'like', 'liked', 'likely', 'likewise', 'little', 'look', 'looking', 'looks', 'low', 'lower', 'ltd', 'm', 'made', 'mainly', 'make', 'makes', 'many', 'may', 'maybe', 'mayn\'t', 'me', 'mean', 'meantime', 'meanwhile', 'merely', 'might', 'mightn\'t', 'mine', 'minus', 'miss', 'more', 'moreover', 'most', 'mostly', 'mr', 'mrs', 'much', 'must', 'mustn\'t', 'my', 'myself', 'n', 'name', 'namely', 'nd', 'near', 'nearly', 'necessary', 'need', 'needn\'t', 'needs', 'neither', 'never', 'neverf', 'neverless', 'nevertheless', 'new', 'next', 'nine', 'ninety', 'no', 'nobody', 'non', 'none', 'nonetheless', 'noone', 'no-one', 'nor', 'normally', 'not', 'nothing', 'notwithstanding', 'novel', 'now', 'nowhere', 'o', 'obviously', 'of', 'off', 'often', 'oh', 'ok', 'okay', 'old', 'on', 'once', 'one', 'ones', 'one\'s', 'only', 'onto', 'opposite', 'or', 'other', 'others', 'otherwise', 'ought', 'oughtn\'t', 'our', 'ours', 'ourselves', 'out', 'outside', 'over', 'overall', 'own', 'p', 'particular', 'particularly', 'past', 'per', 'perhaps', 'placed', 'please', 'plus', 'possible', 'presumably', 'probably', 'provided', 'provides', 'q', 'que', 'quite', 'qv', 'r', 'rather', 'rd', 're', 'really', 'reasonably', 'recent', 'recently', 'regarding', 'regardless', 'regards', 'relatively', 'respectively', 'right', 'round', 's', 'said', 'same', 'saw', 'say', 'saying', 'says', 'second', 'secondly', 'see', 'seeing', 'seem', 'seemed', 'seeming', 'seems', 'seen', 'self', 'selves', 'sensible', 'sent', 'serious', 'seriously', 'seven', 'several', 'shall', 'shan\'t', 'she', 'she\'d', 'she\'ll', 'she\'s', 'should', 'shouldn\'t', 'since', 'six', 'so', 'some', 'somebody', 'someday', 'somehow', 'someone', 'something', 'sometime', 'sometimes', 'somewhat', 'somewhere', 'soon', 'sorry', 'specified', 'specify', 'specifying', 'still', 'sub', 'such', 'sup', 'sure', 't', 'take', 'taken', 'taking', 'tell', 'tends', 'th', 'than', 'thank', 'thanks', 'thanx', 'that', 'that\'ll', 'thats', 'that\'s', 'that\'ve', 'the', 'their', 'theirs', 'them', 'themselves', 'then', 'thence', 'there', 'thereafter', 'thereby', 'there\'d', 'therefore', 'therein', 'there\'ll', 'there\'re', 'theres', 'there\'s', 'thereupon', 'there\'ve', 'these', 'they', 'they\'d', 'they\'ll', 'they\'re', 'they\'ve', 'thing', 'things', 'think', 'third', 'thirty', 'this', 'thorough', 'thoroughly', 'those', 'though', 'three', 'through', 'throughout', 'thru', 'thus', 'till', 'to', 'together', 'too', 'took', 'toward', 'towards', 'tried', 'tries', 'truly', 'try', 'trying', 't\'s', 'twice', 'two', 'u', 'un', 'under', 'underneath', 'undoing', 'unfortunately', 'unless', 'unlike', 'unlikely', 'until', 'unto', 'up', 'upon', 'upwards', 'us', 'use', 'used', 'useful', 'uses', 'using', 'usually', 'v', 'value', 'various', 'versus', 'very', 'via', 'viz', 'vs', 'w', 'want', 'wants', 'was', 'wasn\'t', 'way', 'we', 'we\'d', 'welcome', 'well', 'we\'ll', 'went', 'were', 'we\'re', 'weren\'t', 'we\'ve', 'what', 'whatever', 'what\'ll', 'what\'s', 'what\'ve', 'when', 'whence', 'whenever', 'where', 'whereafter', 'whereas', 'whereby', 'wherein', 'where\'s', 'whereupon', 'wherever', 'whether', 'which', 'whichever', 'while', 'whilst', 'whither', 'who', 'who\'d', 'whoever', 'whole', 'who\'ll', 'whom', 'whomever', 'who\'s', 'whose', 'why', 'will', 'willing', 'wish', 'with', 'within', 'without', 'wonder', 'won\'t', 'would', 'wouldn\'t', 'x', 'y', 'yes', 'yet', 'you', 'you\'d', 'you\'ll', 'your', 'you\'re', 'yours', 'yourself', 'yourselves', 'you\'ve', 'z', 'zero');
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
    public function tf_idf($books)
    {
        $newBook = [];
        $totalFreq = $this->totalFreq($books);
        foreach ($books as $book) {
            $words = $this->wordCount(strtolower($book['title']));
            $bb = [];
            foreach ($words as $word => $val) {
                $bb['term'] = preg_replace("/[^a-zA-Z0-9%\/\s]/", "", $word);
                $bb['doc'] = $book['id'];
                $bb['tf'] = (1 + log($val, 2));
                if (isset($totalFreq[$word])) {
                    $bb['idf'] = log(count($totalFreq) / $totalFreq[$word], 2);
                } else {
                    $bb['idf'] = 0;
                }
                $newBook[] = $bb;
            }
        }
        return $newBook;
    }
    public function readJsonFile()
    {
        $file = storage_path() . "/json/all_books.json";
        $json = @file_get_contents($file);
        $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
        $json = str_replace('&quot;', "\"", $json);
        $obj = json_decode($json, true);

        return $obj;
    }
    public function cosine_similarity($input)
    {
        $books =  $this->readJsonFile();
        $words = $this->wordCount($input);
        $totalFreq = $this->totalFreq($books);
        $cosine_simi = [];
        $group_word = $this->relevent_doc($words);
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
        if ((sqrt($total_wt) * sqrt($total_wq)) != 0) {
            $simi[$doc_num] = $upper / (sqrt($total_wt) * sqrt($total_wq));
        }
        return $simi;
    }
    public function relevent_doc($words)
    {
        $document = [];

        foreach ($words as $word => $val) {
            $simi = [];
            $docs =   DB::table('tf_idfs')->where('term', $word)
                ->get()->toArray();
            $document = array_merge($document, $docs);
        }

        $group_word = $this->group_by('doc', $document);

        return $group_word;
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
    public function ranking($input)
    {
        $books =  $this->readJsonFile();
        $cosine_simi = $this->cosine_similarity($input);
        $rankBook = [];
        foreach ($books as $book) {

            // $newBook['description'] = $book['description'];
            // $newBook['authors'] = array_values($book['authors'])[0];
            // $newBook['publishedDate'] = $book['publishedDate'];
            // $newBook['pageCount'] = $book['pageCount'];
            // $newBook['categories'] = array_values($book['categories'])[0];
            foreach ($cosine_simi as $cosine) {
                if (isset($cosine[$book['id']])) {
                    $newBook = [];
                    $newBook['title'] = $book['title'];
                    $newBook['id'] = $book['id'];
                    $newBook['simi'] = $cosine[$book['id']];
                    $rankBook[] = $newBook;
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
