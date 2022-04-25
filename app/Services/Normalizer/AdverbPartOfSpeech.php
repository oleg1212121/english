<?php


namespace App\Services\Normalizer;


class AdverbPartOfSpeech extends BasePartOfSpeech
{
    # У наречий есть только списки исключений(adv.exc) и итоговый список слов(index.adv).
    # Правила замены окончаний при нормализации слова по правилам у наречий нет.
    public function __construct($pathDict, $excFile, $indexFile)
    {
        parent::__construct($pathDict, $excFile, $indexFile);
    }
}
