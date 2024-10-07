<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LanguageValueExport implements FromCollection, WithHeadings, WithStyles
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'id',
            'Language Phrase',
            'Phrase Value',
        ];
    }
    public function styles(Worksheet $sheet)
    {
        // Set background color for a specific cell range, e.g., A1 to C1
        $sheet->getStyle('A1:C1')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'FFFF00', // Yellow background color
                ],
            ],
        ]);
    }
}



