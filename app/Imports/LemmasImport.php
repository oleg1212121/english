<?php

namespace App\Imports;

use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LemmasImport implements WithMultipleSheets, ShouldQueue, WithChunkReading
{
    public function sheets(): array
    {
        return [
            1 => new LemmasSheetImport(),
            3 => new LemmasWordsSheetImport()
        ];
    }

    public function chunkSize(): int
    {
        return 500;
    }
}
