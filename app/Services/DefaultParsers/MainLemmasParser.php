<?php


namespace App\Services\DefaultParsers;


class MainLemmasParser
{
    public static function fromWordFrequencyData()
    {
        FromWordFrequencyData\LemmasAndFormsXLSX::execute();
        dd("php artisan queue:work --queue=high,default");
    }

    public static function fromWordNetTXT()
    {
        FromWordNetTXT\LemmasAndFormsTXT::execute();
    }

    public static function fromFreeData()
    {
        FromFreeData\LemmasAndFormsTXT::execute();
    }
}
