<?php


namespace App\Services\Normalizer;


class Normalizer
{
    protected static $splitter = "-";
    protected static $parts = [];

    public function __construct($pathDict)
    {
        $adj = new AdjectivePartOfSpeech($pathDict, 'adj.exc', 'index.adj');
        $noun = new NounPartOfSpeech($pathDict, 'noun.exc', 'index.noun');
        $adverb = new AdverbPartOfSpeech($pathDict, 'adv.exc', 'index.adv');
        $verb = new VerbPartOfSpeech($pathDict, 'verb.exc', 'index.verb');

        static::$parts = [$verb, $noun, $adj, $adverb];
    }

    # Метод возвращает лемму слова (возможно, составного)
    public function getLemma($word)
    {
        # Если в слове есть тире, разделим слово на части, нормализуем каждую часть(каждое слово) по отдельности, а потом соединим
        $w_arr = explode(static::$splitter, $word);
        $result = [];
        foreach ($w_arr as $item) {
            $lemma = static::getLemmaWord($item);
            if ($lemma) array_push($result, $lemma);
        }
        if (count($result) > 0) return implode(static::$splitter, $result);

        return null;
    }

    # Метод возвращает лемму(нормализованную форму слова)
    protected function getLemmaWord($word)
    {
        foreach (static::$parts as $item) {
            $lemma = $item->getLemma($word);
            if ($lemma) return $lemma;
        }
        return null;
    }


}
