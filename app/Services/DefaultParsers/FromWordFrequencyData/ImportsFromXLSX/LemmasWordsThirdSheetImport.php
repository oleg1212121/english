<?php


namespace App\Services\DefaultParsers\FromWordFrequencyData\ImportsFromXLSX;

use App\Models\DraftLemma;
use App\Models\Lemma;
use App\Models\LemmasForm;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class LemmasWordsThirdSheetImport implements ToModel, WithUpserts, WithChunkReading, WithStartRow, ShouldQueue
{
    public function model(array $row)
    {
        $form = $row[5] ?? null;
        $lemma = $row[1] ?? null;
//        $pos = LemmasFirstSheetImport::PARTS_OF_SPEECH[trim($row[2])] ?? null;
        $frequency = trim($row[0]) ?? 10000;
//        if(isset($form) && isset($lemma) && isset($pos) && isset($frequency)){
        if(isset($form) && isset($lemma) && isset($frequency)){
            return new DraftLemma([
                'lemma' => $lemma,
                'lemma_form' => $form,
//                'pos' => $pos,
                'frequency' => $frequency,
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
//        return ['lemma_form', 'lemma', "pos"];
        return ['lemma_form', 'lemma'];
    }

    public function startRow(): int
    {
        return 2;
    }
}
