<?php


namespace App\Services\DefaultParsers\FromWordNetTXT;


use App\Services\DefaultParsers\FromWordNetTXT\ParticularClasses\LemmasFormsFromExcTXT;
use App\Services\DefaultParsers\FromWordNetTXT\ParticularClasses\LemmasFormsFromIndexTXT;

class LemmasAndFormsTXT
{
    public static function execute()
    {
        $path = storage_path('app/normalization/wordNet/').'noun.exc';
        $table = "draft_lemmas";
        $formsFromExcSeeder = new LemmasFormsFromExcTXT($path, $table);
        $formsFromExcSeeder->read();
        $path = storage_path('app/normalization/wordNet/').'verb.exc';
//        $formsFromExcSeeder->changeField("path", $path)->setPos( "v")->read();
        $formsFromExcSeeder->changeField("path", $path)->read();
        $path = storage_path('app/normalization/wordNet/').'adv.exc';
//        $formsFromExcSeeder->changeField("path", $path)->setPos( "r")->read();
        $formsFromExcSeeder->changeField("path", $path)->read();
        $path = storage_path('app/normalization/wordNet/').'adj.exc';
//        $formsFromExcSeeder->changeField("path", $path)->setPos( "a")->read();
        $formsFromExcSeeder->changeField("path", $path)->read();

        //2222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222

//        $path = storage_path('app/normalization/wordNet/').'index.noun';
//        $formsFromIndexSeeder = new LemmasFormsFromIndexTXT($path, $table);
//        $formsFromIndexSeeder->read();
//        $path = storage_path('app/normalization/wordNet/').'index.verb';
//        $formsFromIndexSeeder->changeField("path", $path)->setPos( "v")->read();
//        $path = storage_path('app/normalization/wordNet/').'index.adv';
//        $formsFromIndexSeeder->changeField("path", $path)->setPos( "r")->read();
//        $path = storage_path('app/normalization/wordNet/').'index.adj';
//        $formsFromIndexSeeder->changeField("path", $path)->setPos( "a")->read();
    }

}
