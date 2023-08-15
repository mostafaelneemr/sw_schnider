<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class PermissionGroup extends Model
{

    use SoftDeletes,LogsActivity;
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    protected $table = 'permission_groups';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'whitelist_ip'
    ];

    public function permission()
    {
        return $this->hasMany('App\Models\Permission');
    }

    public function staff()
    {
        return $this->hasMany('App\Models\Staff');
    }

}
