<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ListCampaign extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'description',
        'campaign_id',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function phones()
    {
        return $this->belongsToMany(Phone::class, 'list_campaign_phone', 'list_campaign_id', 'phone_id')->withPivot(['is_submit', 'message_id']);
    }

    public static function phonesSend($network)
    {
        ini_set('max_execution_time', 180);
        $count = 0;
        foreach (ListCampaign::all() as  $list) {
            $count += $list->phones()->where('network_id', '=', $network->id)->wherePivot('is_submit', '=', true)->count();
        }
    }

    public static function phonesNotSend($network)
    {
        // ini_set('max_execution_time', 180);
        // return self::phones()->where('network_id', '=', $network->id)->wherePivot('is_submit', '=', false)->count();
        return 0;
    }
}
