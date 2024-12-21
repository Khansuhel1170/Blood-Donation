<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DonationRequestExport implements FromCollection, WithHeadings
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
            'Donation Request ID',
            'Donor Name',
            'Mobile',
            'Email',
            'State',
            'City',
            'Blood Group',
            'medical_condition',
            'status',
        ];
    }
}
