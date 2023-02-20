<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'province_id'
    ];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
    public function phones()
    {
        return $this->hasMany(Phone::class);
    }
}
