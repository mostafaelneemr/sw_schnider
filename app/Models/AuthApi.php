<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthApi extends Model
{
    protected $table = 'auth_api';
    public $timestamps = true;

    protected $dates = ['created_at','updated_at','deleted_at'];
    protected $fillable = [
        'guard_name',
        'access_token',
        'user_id',
        'ip',
        'user_agent',
        'updated_at'
    ];

    public function user(){

        if($this->guard_name == 'api'){
            return $this->belongsTo('App\Models\User','user_id');
        }else{
            return $this->belongsTo('App\Models\Driver','user_id');
        }

    }
}
