<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::get([
            'id', 'avatar', 'name', 'email', 'no_telp', 'role', 'created_at',
            'updated_at', 'isVerified'
        ]);
    }

    public function headings(): array {
        return [
            'ID', 'Avatar', 'Nama', 'Email',
            'No Telp', 'Role', 'Dibuat Pada', 'Diupdate Pada', 'Status Verifikasi' 
        ];
    }
}
