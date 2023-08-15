<?php

namespace App\Models;

 use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Sensor extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['name',
        'serial_number',
        'location_name',
        'status'
    ];
    protected static $logOnlyDirty = true;
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = [
        'name',
        'serial_number',
        'location_id',
        'location_name',
        'status',
        'alarm_status',
        'created_by',
        'type',
        'temperature_value',
        'humidity_value',
        'pressure_diff_value',
        'app_id'
    ];

//    protected static function boot()
//    {
//        parent::boot();
//        static::addGlobalScope( new LocationScope() );
//    }

    public function location()
    {
        return $this->belongsTo( Location::class );
    }

    public function alarmRules()
    {
        return $this->belongsToMany( AlarmRules::class, 'alarm_rules_sensor', 'sensor_id', 'alarm_rules_id' );
    }

    public function createdBy()
    {
        return $this->belongsTo( Staff::class, 'created_by' );
    }

    public function alarms()
    {
        return $this->hasMany( Alarm::class, 'sensor_id' );
    }
    public function measurements()
    {
        return $this->hasMany(Measurement::class,'serial_number');
    }
    public function map_view()
    {
       return $this->belongsTo(MapView::class);
    }

}
