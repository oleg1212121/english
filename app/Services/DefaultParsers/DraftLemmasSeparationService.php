<?php


namespace App\Services\DefaultParsers;


use App\Models\DraftLemma;
use App\Models\Lemma;

class DraftLemmasSeparationService
{
    static $table = "lemmas";
    static $formsTable = "lemmas_forms";
    static $draftTable = "draft_lemmas";
    static $limit = 2000;

    public static function executeLemmasSeed()
    {
//        DraftLemma::select('lemma', 'pos', 'frequency')->orderBy('lemma')->chunk(static::$limit, function ($lemmas) {
        DraftLemma::select('lemma', 'frequency')->orderBy('lemma')->chunk(static::$limit, function ($lemmas) {
            $lemmas = $lemmas->toArray();
            \DB::table(static::$table)->insertOrIgnore($lemmas);
        });
    }

    public static function executeLemmasFormsSeed()
    {
//        \DB::table(static::$draftTable)->select('id', 'lemma', 'lemma_form', 'pos', 'is_exception')->orderBy('id')->chunk(static::$limit, function ($items) {
        \DB::table(static::$draftTable)->select('id', 'lemma', 'lemma_form', 'is_exception')->orderBy('id')->chunk(static::$limit, function ($items) {
            $search = [];
            $forms = [];
            foreach($items as $item) {
                if(!isset($search[$item->lemma])){
                    array_push($search, $item->lemma);
                }
            }
//            $lems = \DB::table(static::$table)->select('id', 'lemma', 'pos')->whereIn('lemma', $search)->get();
            $lems = \DB::table(static::$table)->select('id', 'lemma')->whereIn('lemma', $search)->get();

            foreach ($items as $item) {
//                $lemma = $lems->where('lemma', $item->lemma)->where('pos', $item->pos)->first();
                $lemma = $lems->where('lemma', $item->lemma)->first();
                if($lemma){
                    array_push($forms,[
                        'lemma_id' => $lemma->id,
                        'lemma_form' => $item->lemma_form,
                        'is_exception' => $item->is_exception
                    ]);
                }
            }

            \DB::table(static::$formsTable)->insertOrIgnore($forms);
        });
    }


    public static function setLemmasTable($table = "")
    {
        if(\Schema::hasTable(strtolower($table))){
            static::$table = $table;
        }
    }

    public static function setFormsTable($table = "")
    {
        if(\Schema::hasTable(strtolower($table))){
            static::$formsTable = $table;
        }
    }

    public static function setDraftTable($table = "draft_lemmas")
    {
        if(\Schema::hasTable(strtolower($table))){
            static::$draftTable = $table;
        }
    }

    public static function setLimit($limit = 500)
    {
        if(is_int($limit) && $limit > 0){
            static::$limit = $limit;
        }
    }


}
