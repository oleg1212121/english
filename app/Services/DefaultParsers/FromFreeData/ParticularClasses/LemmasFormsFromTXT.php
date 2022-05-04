<?php


namespace App\Services\DefaultParsers\FromFreeData\ParticularClasses;


use App\Models\Lemma;

class LemmasFormsFromTXT extends BaseParserClass
{
    public function handler($line = null)
    {
        $line = strtolower(trim($line));
        $arr = explode("\t", $line);

        if (stripos($arr[1], "_") === false && stripos($arr[0], "_") === false) {

            $cur = [
                'lemma_form' => trim($arr[1]),
                'lemma' => trim($arr[0]),
                'is_exception' => false,
//                'pos' => $this->pos,
            ];
            return $cur;

        }
        return null;
    }

}
