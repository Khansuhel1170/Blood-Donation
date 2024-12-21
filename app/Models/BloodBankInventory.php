<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodBankInventory extends Model
{
    use HasFactory;

    protected $table = 'blood_bank_inventories';

    protected $fillable = ['blood_bank_id', 'blood_group', 'quantity', 'date_of_collection'];

    public function bloodBank()
    {
        return $this->belongsTo(BloodBank::class);
    }
}
