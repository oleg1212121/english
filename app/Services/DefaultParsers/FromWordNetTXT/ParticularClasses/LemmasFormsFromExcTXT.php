<?php


namespace App\Services\DefaultParsers\FromWordNetTXT\ParticularClasses;


use App\Models\Lemma;

class LemmasFormsFromExcTXT extends BaseParserClass
{
    public function handler($line = null)
    {
        $line = strtolower(trim($line));
        $arr = explode(" ", $line);

        if (stripos($arr[1], "_") === false && stripos($arr[0], "_") === false) {
            $cur = [
                'lemma_form' => trim($arr[0]),
                'lemma' => trim($arr[1]),
//                'pos' => $this->pos,
                'is_exception' => true
            ];
            return $cur;
        }
        return null;
    }

}
