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

    public static function phonesSend($model)
    {
        $datas = [];
        foreach ($model->phones as $value) {
            if ($value->is_submit) {
                $datas[] = $value;
            }
        }
        return $datas;
    }

    public static function phonesNotSend($model)
    {
        $datas = [];
        foreach ($model->phones as $value) {
            if (!$value->is_submit) {
                $datas[] = $value;
            }
        }
        return $datas;
    }
}
