<?php

use App\Models\Measurement;
use App\Models\Sensor;
use Carbon\Carbon;
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

Route::get( '/logout', 'Auth\LoginController@logout' )->name( 'system.logout' ); //


Auth::routes();
// Password Reset Routes...
Route::get( 'password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm' )->name( 'password.request' );
Route::post( 'password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail' )->name( 'password.email' );
Route::get( 'password/reset/{token}', 'Auth\ResetPasswordController@showResetForm' )->name( 'password.reset' );
Route::post( 'password/reset', 'Auth\ResetPasswordController@reset' );

Route::get( '/staff/change-password', 'StaffController@changePassword' )->name( 'system.staff.change-password' );
Route::post( '/staff/change-password', 'StaffController@changePasswordPost' )->name( 'system.staff.change-password-post' );

Route::resource( '/staff', 'StaffController', ['as' => 'system'] ); //

Route::get( '/profile/{staff}', 'StaffController@getProfile' )->name( 'system.get-profile' ); //
Route::post( '/profile/{staff}', 'StaffController@updateProfile' )->name( 'system.update-profile' ); //

// -- Setting
Route::get( '/setting', 'SettingController@index' )->name( 'system.setting.index' ); //
Route::patch( '/setting', 'SettingController@update' )->name( 'system.setting.update' );

// -- Setting

Route::get( '/ajax', 'AjaxController@index' )->name( 'system.ajax.post' ); //
 
Route::get( '/auth-sessions', 'AuthSessionController@index' )->name( 'system.staff.auth-sessions' );
Route::delete( '/auth-sessions', 'AuthSessionController@deleteAuthSession' )->name( 'system.staff.delete-auth-sessions' );

Route::get( '/activity-log/{ID}', 'ActivityController@show' )->name( 'system.activity-log.show' ); //
Route::get( '/activity-log', 'ActivityController@index' )->name( 'system.activity-log.index' ); //

Route::get( '/', 'SystemController@dashboard' )->name( 'system.dashboard' );
Route::get( '/measurements', 'SystemController@measurements' )->name( 'system.measurements' );

Route::resource( '/company', 'CompanyController', ['as' => 'system'] ); //
Route::resource( '/warehouse', 'WarehouseController', ['as' => 'system'] );//
Route::resource( '/inventory', 'InventoryController', ['as' => 'system'] );//
Route::resource( '/sensor', 'SensorController', ['as' => 'system'] ); //
Route::post( '/sensor-status/{sensor}', 'SensorController@updateStatus' )->name( 'sensor.update-status' ); //
Route::post( '/sensor-location', 'SensorController@updateLocation' )->name( 'sensor.update-location' ); //
Route::post( '/sensor-name', 'SensorController@updateName' )->name( 'sensor.update-name' ); //



Route::get( 'location', 'LocationController@create' )->name( 'system.location.create' );


Route::post( '/locations-action', 'LocationController@locationsAction' )->name( 'system.locations-action' );
Route::get( '/locations', 'LocationController@locations' )->name( 'system.locations' );

Route::get( 'sensorDetailsMeasurements/{sensor}', 'SensorController@sensorDetailsMeasurements' )->name( 'system.sensorDetailsMeasurements' );



Route::get( 'logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index' );


