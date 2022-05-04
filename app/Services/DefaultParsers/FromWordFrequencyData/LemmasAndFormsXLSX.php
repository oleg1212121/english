<?php


namespace App\Services\DefaultParsers\FromWordFrequencyData;


use App\Services\DefaultParsers\FromWordFrequencyData\ImportsFromXLSX\LemmasImport;
use Maatwebsite\Excel\Facades\Excel;

class LemmasAndFormsXLSX
{
    public static function execute()
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
