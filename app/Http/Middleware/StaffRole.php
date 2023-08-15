<?php
/**
 * Created by PhpStorm.
 * User: Tech2
 * Date: 9/7/2017
 * Time: 9:39 AM
 */

namespace App\Http\Middleware;

use App\Models\Sensor;
use App\Models\Staff;
use Closure;
use Auth;
use Illuminate\Http\Request;

class StaffRole
{

    public function handle($request, Closure $next, $role){

        \View::share( 'sensors', Sensor::with( 'location:id,name' )->get() );
        if($request->user()->status == 'in-active'){
            Auth::logout();
            return redirect('/system/login');
        }
        $ignoredRoutes = ['system.locations-action','system.locations','system.location.create','system.dashboard','system.ajax.post','system.sensorDetailsRules',
            'system.sensorDetailsAlarms','system.sensorDetailsMeasurements','sensor.update-name','system.GenerateReport'];
        $canAccess = array_merge($ignoredRoutes,Staff::StaffPerms($request->user()->id)->toArray());
        if (!in_array($role,$canAccess)){
            if ($request->ajax()){
                abort(401, 'لا تملك الصلاحيه');
            }
            abort(401);
            return response()->view('errors.401', ['exception'=>'Unauthorized'], 500);

        }
        return $next($request);
    }

}
