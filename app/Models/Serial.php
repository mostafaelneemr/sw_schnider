<?php

namespace App\Models;

 use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Serial extends Model
{
    protected $dates = ['created_at', 'updated_at'];
    protected $table = 'serials';
    protected $fillable = [
        'serial_number',
    ];

}
