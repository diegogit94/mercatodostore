<?php

namespace App\Exports;

use App\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\BaseDrawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ProductsExport implements FromCollection, ShouldAutoSize, WithDrawings, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::select([
            'id',
            'name',
            'description',
            'short_description',
            'image',
            'price',
            'quantity',
            'visible',
        ])->get();
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('/img/store-logo.png'));
        $drawing->setHeight(60);
        $drawing->setCoordinates('J2');

        return $drawing;
    }

    public function headings(): array
    {
        return ([
            'id',
            'name',
            'description',
            'short_description',
            'image',
            'price',
            'quantity',
            'visible',
        ]);
    }
}
