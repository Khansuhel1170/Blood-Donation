<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DonorsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $donors;

    public function __construct($donors)
    {
        $this->donors = $donors;
    }

    public function collection()
    {
        return $this->donors;
    }

    public function headings(): array
    {
        return [
            'Donor ID',
            'Donor Name',
            'Mobile',
            'Email',
            'State',
            'District',
            'City',
            'Address',
            'Blood Group',
            'Has Donted Previoulsy',
            'Late Donation Date',
            'Donation Count'
        ];
    }
}
