<?php

namespace App\Exports;

use App\Product;
use http\Env\Request;
use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\BaseDrawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ProductsExport implements FromQuery, ShouldAutoSize, WithDrawings, WithHeadings
{
    use Exportable;

    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
    * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $request = $this->request;

        if (array_key_exists('name', $request))
        {
            return Product::query()
            ->Where('name', $request['name']);

        }elseif (array_key_exists('category', $request))
        {
            return Product::query()
                ->where('category_id', $request['category']);

        }elseif (array_key_exists('price', $request))
        {
            return Product::query()
                ->where('price', $request['price']);

        }elseif (array_key_exists('visible', $request))
        {
            return Product::query()
                ->orwhere('visible', $request['visible']);

        }

        return Product::query();
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
