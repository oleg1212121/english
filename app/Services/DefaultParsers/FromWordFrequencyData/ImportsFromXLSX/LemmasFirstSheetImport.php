<?php

namespace App\Services\DefaultParsers\FromWordFrequencyData\ImportsFromXLSX;

use App\Models\Lemma;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class LemmasFirstSheetImport implements ToModel, WithUpserts, WithChunkReading, WithStartRow, ShouldQueue
{
    const PARTS_OF_SPEECH = [
        'a' => 'article',
        'c' => 'conjunction',
        'd' => 'determiner',
        'e' => 'existential there',
        'i' => 'preposition',
        'j' => 'adjective',
        'm' => 'number',
        'n' => 'noun',
        'p' => 'pronoun',
        'r' => 'adverb',
        't' => 'infinitive marker to',
        'u' => 'interjection',
        'v' => 'verb',
        'z' => 'letter of the alphabet',
        'x' => 'not, n"t',
    ];

    public function model(array $row)
    {
        $pos = static::PARTS_OF_SPEECH[strtolower($row[2])] ?? 'noun';
        $lemma = $row[1] ?? null;
        $rank = intval($row[0]) ?? null;
        if(isset($lemma) && isset($rank)){
            return new Lemma([
                'lemma' => $lemma,
                'pos' => $pos,
                'frequency' => $rank,
            ]);
        }
        return null;
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public function uniqueBy()
    {
        return ['lemma', 'pos'];
    }

    public function startRow(): int
    {
        return 2;
    }
}
