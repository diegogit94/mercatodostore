<?php

namespace App\Imports;

use App\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductsImport implements ToModel, WithHeadingRow, WithValidation
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

    public function rules(): array
    {
        return [
            'name' => 'required|min:2|max:100',
            'description' => 'required|min:2|max:200',
            'short_description' => 'required|min:2|max:100',
            'image' => 'max:200',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'visible' => 'boolean',
            'category_id' => 'exists:products'
        ];
    }
}
