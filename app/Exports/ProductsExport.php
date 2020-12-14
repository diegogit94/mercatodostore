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

class ProductsExport implements FromQuery, WithHeadings
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

        return Product::name($request->name)
            ->price($request->price)
            ->visible($request->visible)
            ->category($request->category_id);
    }

    public function headings(): array
    {
        return ([
            'id',
            'name',
            'slug',
            'description',
            'short_description',
            'image',
            'price',
            'quantity',
            'visible',
            'category_id',
            'created_at',
            'updated_at'
        ]);
    }
}
