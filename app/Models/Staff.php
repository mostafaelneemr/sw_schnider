<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Tenancy\Identification\Contracts\Tenant;
use Tenancy\Identification\Concerns\AllowsTenantIdentification;

class Staff extends Authenticatable implements Tenant
{

    use LogsActivity, AllowsTenantIdentification,SoftDeletes, Notifiable, AllowsTenantIdentification, Notifiable;

    protected static $logAttributes = ['name','email'];

    protected $table = 'staff';
    public $timestamps = true;

    public $modelPath = 'App\Models\Staff';
    protected $dates = ['lastlogin', 'created_at', 'updated_at', 'deleted_at'];
    protected $fillable = [
        'name',
         'email',

        'password',
        'remember_token',

        'status',
        'language_id',

        'language',
        'language_data_key',

    ];
    protected $hidden = array('password', 'remember_token');
    protected static $logOnlyDirty = true;

    public function getTenantKeyName(): string
    {
        return 'id';
    }

    public function getTenantIdentifier(): string
    {
        return get_class( $this );
    }

    public function getTenantKey()
    {
        return $this->id;
    }

    public function reminders()
    {
        return $this->hasMany( 'App\Models\Reminder', 'staff_id' )
            ->orderByDesc( 'date_time' );
    }


    public function calls()
    {
        return $this->hasMany( 'App\Models\Call', 'created_by_staff_id' )
            ->select( [
                'id',
                'client_id',
                'call_purpose_id',
                'call_status_id',
                'type',
                'description',
                'created_by_staff_id',
                'created_at'
            ] )
            ->orderByDesc( 'id' )
            ->with( [
                'client',
                'call_purpose',
                'call_status',
                'staff'
            ] );
    }


    public static function StaffPerms($staffID)
    {
        return Staff::find( $staffID )->permission->pluck( 'route_name' );
    }

    public function getFullnameAttribute($key)
    {
        return $this->name ?? '';
    }

    public function is_supervisor()
    {
        return $this->permission_group->is_supervisor == 'yes';
    }

    public function managed_staff()
    {
        return $this->hasMany( 'App\Models\Staff', 'supervisor_id' )->where( 'status', 'active' );
    }


    public function managed_staff_ids()
    {
        if ($this->permission_group->is_supervisor == 'no')
            return [$this->id];

        $data = $this->hasMany( 'App\Models\Staff', 'supervisor_id' )->where( 'status', 'active' )->get( ['id'] );
        if (!$data)
            return [$this->id];

        $data = $data->toArray();

        return array_merge( [$this->id], array_column( $data, 'id' ) );
    }

    public function permission_group()
    {
        return $this->belongsTo( 'App\Models\PermissionGroup', 'permission_group_id' );
    }

    public function permission()
    {
        return $this->hasManyThrough( 'App\Models\Permission', 'App\Models\PermissionGroup', 'id', 'permission_group_id', 'permission_group_id' );
    }


    public function order_comments()
    {
        return $this->morphMany( 'App\Models\OrderComment', 'created' );
    }


}
