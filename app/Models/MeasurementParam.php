<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Spatie\Activitylog\Traits\LogsActivity;

class MeasurementParam extends Model
{
//    use LogsActivity;
//
//    protected static $logAttributes = ['*'];
    protected $table = 'measurement_params';
    protected $dates = ['created_at', 'updated_at'];
    public $timestamps = false;
    protected $fillable = [
        'measurement_id',
        'channel',
        'value',
        'type',
    ];

   public function measurement()
   {
       return $this->belongsTo(Measurement::class,'measurement_id');
   }

}
