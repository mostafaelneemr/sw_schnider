<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Inventory extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected $dates = ['created_at', 'updated_at'];
    protected $table = 'inventory';
    protected $fillable = [
        'warehouse_id',
        'name',
        'inventory_number',
        'storing_category'

  

    ];

    public function warehouse(){
        return $this->belongsTo('App\Models\Warehouse');
    }
}
