<?php


namespace App\Services\Normalizer;


class VerbPartOfSpeech extends BasePartOfSpeech
{
    public function __construct($pathDict, $excFile, $indexFile)
    {
        parent::__construct($pathDict, $excFile, $indexFile);
        $this->rule = [
            ["s"   , ""  ],
            ["ies" , "y" ],
            ["es"  , "e" ],
            ["es"  , ""  ],
            ["ed"  , "e" ],
            ["ed"  , ""  ],
            ["ing" , "e" ],
            ["ing" , ""  ]
        ];
    }

    # Метод получения нормализованной формы слова GetLemma(word) определен в базовом классе BaseWordNetItem

}
