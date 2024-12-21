<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationRequest extends Model
{
    use HasFactory;

    protected $table = 'donation_requests';
    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }
}
