<?php

namespace App\Imports;

use App\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            'name' => $row['name'],
            'description' => $row['description'],
            'short_description' => $row['short_description'],
            'image' => $row['image'],
            'price' => $row['price'],
            'quantity' => $row['quantity'],
            'visible' => $row['visible'],
            'category_id' => $row['category_id']
        ]);
    }
}
