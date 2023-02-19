<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Phone extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'number',
        'network_id',
        'city_id',
        'is_submit'
    ];

    public function network()
    {
        return $this->belongsTo(Network::class);
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
