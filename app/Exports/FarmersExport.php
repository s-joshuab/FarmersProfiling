<?php

namespace App\Exports;

use App\Models\FarmersProfile;
use Maatwebsite\Excel\Concerns\FromCollection;

class FarmersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return FarmersProfile::all();
    }
}
