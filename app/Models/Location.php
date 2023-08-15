<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Builder;
class Location extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['name'];
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = [
        'name',
        'parent_id',
        'created_by',
    ];
//    protected static function booted()
//    {
//        if (auth()->check()) {
//            static::addGlobalScope( 'id', function (Builder $builder) {
//                $builder->whereIn( 'id', explode( ',', auth()->user()->location_list ) );
//            } );
//        }
//    }
    public function parent()
    {
        return $this->belongsTo( Location::class ,'parent_id');
    }

    public function createdBy()
    {
        return $this->belongsTo( Staff::class, 'created_by' );
    }


}
