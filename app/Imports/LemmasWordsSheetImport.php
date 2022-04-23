<?php

namespace App\Imports;

use App\Models\LemmasForm;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class LemmasWordsSheetImport implements ToModel, WithUpserts, WithChunkReading, WithStartRow, ShouldQueue
{
    public function model(array $row)
    {
        $form = $row[5] ?? null;
        $rank = intval($row[0]) ?? null;
        if(isset($form) && isset($rank)){
            return new LemmasForm([
                'lemma_form' => $row[5],
                'lemma_rank' => intval($row[0]),
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
        return ['lemma_form', 'lemma_rank'];
    }

    public function startRow(): int
    {
        return 2;
    }
}
