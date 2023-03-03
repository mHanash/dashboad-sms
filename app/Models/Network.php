<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Network extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name'
    ];

    public function phones()
    {
        return $this->hasMany(Phone::class);
    }
    public static function phonesSend($network)
    {
        $count = 0;
        foreach (ListCampaign::all() as $list) {
            $count += $list->phones()->where('network_id', '=', $network->id)->wherePivot('is_submit', '=', true)->count();
        }
        return $count;
    }

    public static function phonesNotSend($network)
    {
        $count = 0;
        foreach (ListCampaign::all() as $list) {
            $count += $list->phones()->where('network_id', '=', $network->id)->wherePivot('is_submit', '=', false)->count();
        }
        return $count;
    }
}
