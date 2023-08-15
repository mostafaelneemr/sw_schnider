<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Company extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected $table = 'company';
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = [
        'name',
        'sfda',
        'commercial_record_number',
        'commercial_record_is_sue_date_hijri',
        'date_of_birth_hijri',
        'date_of_birth_gregorian',
        'phone',
        'extension_number',
        'email',
        'manager_name',
        'manager_phone',
        'manager_mobile',


    ];


}
