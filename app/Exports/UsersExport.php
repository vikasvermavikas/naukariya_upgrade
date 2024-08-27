<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Tracker;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Tracker::all();
    }

    public function headings(): array
    {
        return ["id", "name", "email", 'jobtitle', 'status', 'created_at", "updated_at'];
    }
}
