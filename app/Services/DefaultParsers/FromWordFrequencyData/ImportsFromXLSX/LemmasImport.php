<?php


namespace App\Services\DefaultParsers\FromWordFrequencyData\ImportsFromXLSX;


use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LemmasImport implements WithMultipleSheets, ShouldQueue, WithChunkReading
{
    public function sheets(): array
    {
        return [
//            1 => new LemmasFirstSheetImport(),
            3 => new LemmasWordsThirdSheetImport()
        ];
    }

    public function chunkSize(): int
    {
        return 500;
    }
}
