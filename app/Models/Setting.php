<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'name',
        'value'
    ];

    public function getOptionListAttribute($value){
        $value = @unserialize($value);
        if(!is_array($value)){
            return [];
        }
        return $value;
    }

}