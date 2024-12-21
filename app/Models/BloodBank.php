<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodBank extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone', 'email', 'address', 'state', 'district', 'city', 'license_no', 'blood_type_available'];

    public function bloodBankInventory()
    {
        return $this->hasMany(bloodBankInventory::class);
    }
    
}
