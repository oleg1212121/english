<?php


namespace App\Services\Normalizer;


class AdjectivePartOfSpeech extends BasePartOfSpeech
{
    public function __construct($pathDict, $excFile, $indexFile)
    {
        parent::__construct($pathDict, $excFile, $indexFile);
        static::$rule = [
            ["er", ""],
            ["er", "e"],
            ["est", ""],
            ["est", "e"]
        ];
    }
}
