<?php

namespace App\Exports;

use App\User;
use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\BaseDrawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class UsersExport implements FromCollection, ShouldAutoSize, WithDrawings, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::select(['id',
                'name',
                'email',
                'user_type',
                'active'])->get();
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('/img/store-logo.png'));
        $drawing->setHeight(60);
        $drawing->setCoordinates('G2');

        return $drawing;
    }

    public function headings(): array
    {
        return ([
            'id',
            'name',
            'email',
            'user_type',
            'active',
        ]);
    }
}
