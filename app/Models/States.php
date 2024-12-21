<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class States extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    public function cities()
    {
        return $this->hasManyThrough(Cities::class, Districts::class);
    }

    public function districts()
    {
        return $this->hasMany(Districts::class);
    }
}
