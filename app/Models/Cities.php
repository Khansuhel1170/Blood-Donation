<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    use HasFactory;

    Protected $fillable = ['name','district_id','state_id'];

    public function districts()
    {   
        return $this->belongsTo(Districts::class);
    }

    public function states()
    {
        return $this->belongsTo(States::class);
    }
    
}
