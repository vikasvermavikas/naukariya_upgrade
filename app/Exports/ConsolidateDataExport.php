<?php

namespace App\Exports;

use App\Models\ConsolidateData;
use Maatwebsite\Excel\Concerns\FromCollection;

class ConsolidateDataExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ConsolidateData::all();
    }
}
