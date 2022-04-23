<?php


namespace App\Services;


use App\Imports\LemmasImport;
use Maatwebsite\Excel\Facades\Excel;

class WordFrequencyDataService
{

    public static function ParsingDataFile()
    {
        $path = storage_path('app/normalization') . '/wordFrequency.xlsx';

        if (file_exists($path)) {
            Excel::import(new LemmasImport(), $path);
            return true;
        } else {
            return false;
        }
    }

}
