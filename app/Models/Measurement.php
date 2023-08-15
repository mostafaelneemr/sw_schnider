<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Spatie\Activitylog\Traits\LogsActivity;

class Measurement extends Model
{
//    use LogsActivity;
//
//    protected static $logAttributes = ['*'];
    protected $dates = ['created_at', 'updated_at','measured_at','next_measured_at'];
    protected $fillable = [
        'serial_number',
        'response_handle',
        'battery',
        'signal',
        'measurement_interval',
        'measured_at',
        'next_measured_at',
        'xml_at',
        'wasl_at',
    ];

    public function params()
    {
        return $this->hasMany( MeasurementParam::class, 'measurement_id' );
    }
}
