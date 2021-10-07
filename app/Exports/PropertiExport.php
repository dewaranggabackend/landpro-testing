<?php

namespace App\Exports;

use App\Models\properti;
use Maatwebsite\Excel\Concerns\FromCollection;

class PropertiExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return properti::all();
    }
}
