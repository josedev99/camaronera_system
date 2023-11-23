<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;

class ReportG implements FromCollection, WithHeadings,  WithCustomStartCell, WithTitle, WithStyles
{
    public $data, $headers, $title;
    /**
    * @return \Illuminate\Support\Collection
    */
    function __construct($data, $headers, $title)
    {
        $this->data = $data;
        $this->headers = $headers;
        $this->title = $title;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings() : array
    {
        return $this->headers;
    }

    public function startCell(): string
    {
        return 'B2';
    }

    public function styles(Worksheet $sheet)
    {
       return [
        2 => ['font' => ['bold' => true]],

       ];
    }

    public function title(): string
    {
        
        return $this->title;
    }
}
