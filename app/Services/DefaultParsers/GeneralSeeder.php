<?php


namespace App\Services\DefaultParsers;


class GeneralSeeder
{
    public static function execute()
    {
//        MainLemmasParser::fromWordFrequencyData();
        // proceed the jobs "php artisan queue:work --queue=high,default"
        // parsing from wordnet dictionary
        MainLemmasParser::fromWordNetTXT();
        // parsing from free data file
        MainLemmasParser::fromFreeData();
        // separate whole data between lemma's and form's tables

        // seed the lemmas table
        DraftLemmasSeparationService::executeLemmasSeed();
        // seed the forms table
        DraftLemmasSeparationService::executeLemmasFormsSeed();
    }
}
