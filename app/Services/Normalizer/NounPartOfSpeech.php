<?php


namespace App\Services\Normalizer;


class NounPartOfSpeech extends BasePartOfSpeech
{

    public function __construct($pathDict, $excFile, $indexFile)
    {
        parent::__construct($pathDict, $excFile, $indexFile);
        static::$rule = [
            ["s"    , ""    ],
            ["’s"   , ""    ],
            ["’"    , ""    ],
            ["ses"  , "s"   ],
            ["xes"  , "x"   ],
            ["zes"  , "z"   ],
            ["ches" , "ch"  ],
            ["shes" , "sh"  ],
            ["men"  , "man" ],
            ["ies"  , "y"   ]
        ];
    }

    # Метод возвращает лемму сушествительного(нормализованную форму слова)
    # Этот метод есть в базовом классе BaseWordNetItem, но нормализация существительных несколько отличается от нормализации других частей речи,
    # поэтому метод в наследнике переопределен
    public function getLemma($word)
    {
        $word = strtolower(trim($word));

        # Если существительное слишком короткое, то к нормализованному виду мы его не приводим
        if(strlen($word) <= 2) return null;

        # Если существительное заканчивается на "ss", то к нормализованному виду мы его не приводим
        if(BasePartOfSpeech::endsWith($word, "ss")) return null;

        # Пройдемся по кэшу, возможно слово уже нормализовывалось раньше и результат сохранился в кэше
        $lemma = static::getDictValue(static::$cacheWords, $word);
        if($lemma) return $lemma;

        # Пройдемся по исключениям, если слово из исключений, вернем его нормализованную форму
        $lemma = static::getDictValue(static::$exceptions, $word);
        if($lemma) return $lemma;

        # Проверим, если слово уже в нормализованном виде, вернем его же
        if(static::isDefined($word)) return $word;

        # Если существительное заканчивается на "ful", значит отбрасываем "ful", нормализуем оставшееся слово, а потом суффикс приклеиваем назад.
        # Таким образом, к примеру, из слова "spoonsful" после нормализации получится "spoonful"
        $suff = "";
        if(BasePartOfSpeech::endsWith($word, "ful")){
            $word = \Str::beforeLast($word, "ful");
            $suff = "ful";
        }

        # На этом шаге понимаем, что слово не является исключением и оно не нормализовано, значит начинаем нормализовывать его по правилам.
        $lemma = static::ruleNormalization($word);
        if($lemma){
            $lemma .= $suff;
            static::$cacheWords[$word] = $lemma;
            return $lemma;
        }
        return null;
    }
}
