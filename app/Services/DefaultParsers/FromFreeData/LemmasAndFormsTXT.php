<?php


namespace App\Services\DefaultParsers\FromFreeData;


use App\Services\DefaultParsers\FromFreeData\ParticularClasses\LemmasFormsFromTXT;
use App\Services\DefaultParsers\FromFreeData\ParticularClasses\LemmasFormsSecondFromTXT;

class LemmasAndFormsTXT
{
    public static function execute()
    {
        $path = storage_path('app/normalization/free_data/').'lems.txt';
        $table = "draft_lemmas";
        $lemmasFormsSeeder = new LemmasFormsFromTXT($path, $table);
        $lemmasFormsSecondSeeder = new LemmasFormsSecondFromTXT($path, $table);
        $lemmasFormsSeeder->read();
        $lemmasFormsSecondSeeder->read();
    }
}
