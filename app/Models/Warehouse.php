<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Warehouse extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected $dates = ['created_at', 'updated_at'];
    protected $table = 'warehouse';
    protected $fillable = [
        'company_id',
        'name',
        'city',
        'address',
        'latitude',
        'longitude',
        'land_coordinates',
        'license_number',
        'license_issue_date',
        'license_expiry_date',
        'phone',
        'manager_mobile',
        'email',
        'land_area_in_square_meter',


    ];

    public function company(){
        return $this->belongsTo('App\Models\Company');
    }
}
