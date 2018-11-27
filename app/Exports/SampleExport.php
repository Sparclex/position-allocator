<?php

namespace App\Exports;

use App\Sample;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class SampleExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect(Sample::orderBy('position')->get()->toArray())->map(function($sample) {
            return [
                'id' => $sample['id'],
                'position' => $sample['computedPosition']
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Position',
        ];
    }
}
