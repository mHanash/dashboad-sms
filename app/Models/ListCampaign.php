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
        return $this->belongsToMany(Phone::class, 'list_campaign_phone', 'list_campaign_id', 'phone_id')->withPivot('is_submit');
    }
}
