<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersTemplateExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [
            // Contoh 1 baris data
            [
                'John Doe',
                'johndoe@example.com',
                'A001',
                '081234567890',
                'Jl. Contoh No. 123, Perumahan XYZ',
                'password123'
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'nama',
            'email',
            'no_rumah',
            'no_tlp',
            'alamat',
            'password'   // optional, kalau kosong akan pakai password123
        ];
    }
}