<?php

namespace App\Modules\System;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\MapView;
use App\Models\Measurement;
use App\Models\MeasurementParam;
use App\Models\Sensor;
use App\Models\Setting;
use Datatables;
use http\Env\Request;

class SystemController extends Controller
{
    protected $viewData = [
        'breadcrumb' => []
    ];

    public function __construct()
    {
        // $this->middleware(['auth:staff']);
        $this->middleware( ['auth:staff'] );

    }

    public function ValidationError($validation, $message)
    {
        $errorArray = $validation->errors()->messages();

        $data = array_column( array_map( function ($key, $val) {
            return ['key' => $key, 'val' => implode( '|', $val )];
        }, array_keys( $errorArray ), $errorArray ), 'val', 'key' );
        return [
            'status' => false,
            'msg' => implode( "\n", array_flatten( $errorArray ) ),
            'data' => $data
        ];
    }

    public function permissions($permission = false)
    {

        $permissions = \Illuminate\Support\Facades\File::getRequire( 'app/Modules/System/Permissions.php' );
        return $permission ? isset( $permissions[$permission] ) ? $permissions[$permission] : false : $permissions;
    }

    protected function view($file, array $data = [])
    {
        return view( 'system.' . $file, $data );
    }

    protected function response($status, $code = '200', $message = 'Done', $data = []): array
    {
        return [
            'status' => $status,
            'code' => $code,
            'message' => $message,
            'data' => $data
        ];
    }

    public function dashboard(\Illuminate\Http\Request $request)
    {
        // notifyStaff("New Order salman",route('system.sensor.show',5));
        $location = Location::whereNull( 'parent_id' )->first();
        // dd($location);
        $this->viewData['breadcrumb'][] = [
            'text' => $location ? $location->name : ''
        ];
        if ($request->isDataTable) {

            $eloquentData = Sensor::select( [
                'id',
                'name',
                'status',
                'serial_number',
                'location_id',
                'created_by',
                'type',
                'alarm_status',
                'created_at',
                'temperature_value',
                'pressure_diff_value',
                'humidity_value',
                'location_name'
            ] )
                ->with( 'location:id,name' );

            if ($request->name) {
                $eloquentData->where( function ($query) use ($request) {
                    $query->where( 'name', 'LIKE', '%' . $request->name . '%' );
                } );
            }

            if ($request->serial_number) {
                $eloquentData->where( 'serial_number', 'LIKE', '%' . $request->serial_number . '%' );
            }

            if ($request->location_id) {
                $eloquentData->where( 'location_id', $request->location_id );
                // $eloquentData->where( 'location_id', 'LIKE', '%' . $request->location_id . '%' );
            }

            if ($request->type) {
                $eloquentData->whereIn( 'type', (array)$request->type );
            }

            if ($request->downloadExcel == "true") {
                return redirect()->back()->with( 'success', 'cars.Car has been created ...!' );
            }

            return Datatables::of( $eloquentData )
                ->addColumn( 'name', function ($data) {
                    return   '<p>' . $data->name . '</p>' . '<p>' . $data->serial_number . '</p>';
                } )
                ->addColumn( 'location_name', function ($data) {
                    return $data->location_name;
                } )
                ->addColumn( 'value', function ($data) {
                    $string = '';
                    if(!empty($data->pressure_diff_value)) {
                        $string .= ' <span  data-toggle="tooltip" data-theme="dark" title="pressure_diff"><i class="fas fa-tachometer-alt"></i>' . $data->pressure_diff_value . '</span>';
                        $string .= ' ';
                    }
                    if(!empty($data->temperature_value)) {
                        $string .= '<span  data-toggle="tooltip" data-theme="dark" title="Temperature"><i class="fas fa-temperature-high"></i>' . $data->temperature_value . '</span>';
                        $string .= ' ';
                    }
                    if(!empty($data->humidity_value)) {
                        $string .= '<span  data-toggle="tooltip" data-theme="dark" title="Humidity"><i class="fas fa-hand-holding-water"></i>' . $data->humidity_value . '</span>';
                    }
                    return $string;
                } )
                ->addColumn( 'measured', function ($data) {
                    $measured_at = Measurement::where( 'serial_number', $data->serial_number )->latest()->first();
                    if ($measured_at) {
                        return $measured_at->created_at->diffForHumans();
                    }
                } )

                ->addColumn( 'action', function ($data) {
                    return '<span class="dropdown">
                            <a href="#" class="btn btn-md btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="false">
                              <i class="la la-gear"></i>
                            </a>
                            <div class="dropdown-menu ' . ((\App::getLocale() == 'ar') ? 'dropdown-menu-left' : 'dropdown-menu-right') . '" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-36px, 25px, 0px);">
 
                                <a class="dropdown-item" href="javascript:void(0);" onclick="deleteSensor(\'' . route( 'system.sensor.destroy', $data->id ) . '\')">' . __( 'Delete' ) . '</a>
                                <a data-sensor_id = ' . $data->id . ' data-location_id=' . $data->location_id . ' class="dropdown-item" title="Change Location" href="javascript:;" data-toggle="modal" data-target="#change-location-modal"></i> ' . __( 'Change Location' ) . '</a>

                            </div>
                        </span>';
                } )
                ->escapeColumns( [] )
                ->make( true );
        } else {
            // View Data
            $this->viewData['tableColumns'] = [

                __( 'Name/Serial' ),
                __( 'Location' ),
                __( 'value' ),
                __( 'Measured' ),
                __( 'Action' ),
            ];
            $this->viewData['js_columns'] = [
                'name' => 'sensors.name',
                'location_name' => 'sensors.location_name',
                'value' => 'value',
                'measured' => 'measured',
                'action' => 'action'
            ];
            $this->viewData['locations'] = array_column( Location::all()->toArray(), 'name', 'id' );
            $this->viewData['pageTitle'] = __( 'Dashboard' );
            return $this->view( 'dashboard', $this->viewData );
        }
    }

    public function measurements(\Illuminate\Http\Request $request)
    {
        if ($request->isDataTable) {

            $eloquentData = Measurement::select( [
                'id',
                'serial_number',
                 'battery',
                'measured_at',
                'xml_at',
                'wasl_at',
                'created_at'
            ] )
                ->with( 'params' )->orderBy( 'id','desc' );

            if ($request->id) {
                $eloquentData->where( 'id', '=', $request->id );
            }

            if ($request->serial_number) {
                $eloquentData->where( 'serial_number', '=', $request->serial_number );
            }

            whereBetween($eloquentData,'created_at',$request->created_at1,$request->created_at2);
            whereBetween($eloquentData,'measured_at',$request->measured_at1,$request->measured_at2);
            whereBetween($eloquentData,'xml_at',$request->xml_at1,$request->xml_at2);
            whereBetween($eloquentData,'wasl_at',$request->wasl_at1,$request->wasl_at2);



            return Datatables::of( $eloquentData )
                ->addColumn( 'id', '{{$id}}' )
                ->addColumn( 'serial_number', '{{$serial_number}}' )
                ->addColumn( 'battery', '{{$battery}}' )
                ->addColumn( 'values', function ($data) {
                    foreach ($data->params as $key => $param) {
                        $string = '';
                        if ($param->type == 'pressure_diff') {
                            $string .= '
                <span  data-toggle="tooltip" data-theme="dark" title="pressure_diff"><i class="fas fa-tachometer-alt"></i>' . $param->value . '</span>';
                            $string .= ' ';
                        }
                        if ($param->type == 'temperature') {
                            $string .= '
                <span  data-toggle="tooltip" data-theme="dark" title="Temperature"><i class="fas fa-temperature-high"></i>' . $param->value . '</span>';
                            $string .= ' ';
                        }
                        if ($param->type == 'humidity') {
                            $string .= '<span  data-toggle="tooltip" data-theme="dark" title="Humidity"><i class="fas fa-hand-holding-water"></i>' . $param->value . '</span>';

                        }
                    }
                    return $string;
                } )
                ->addColumn( 'measured_at', function($data){
                    return date('Y-m-d H:i:s',strtotime($data['measured_at']));
                } )

                ->addColumn( 'xml_at', function($data){
                    if($data->xml_at) {
                        return date('Y-m-d H:i:s', strtotime($data['xml_at']));
                    }
                } )
                ->addColumn( 'wasl_at', function($data){
                    if($data->wasl_at) {
                        return date('Y-m-d H:i:s', strtotime($data['wasl_at']));
                    }
                } )
                ->addColumn( 'created_at', function($data){
                    return date('Y-m-d H:i:s',strtotime($data['created_at']));
                } )


                ->escapeColumns( [] )

                ->make( true );
        } else {
            // View Data
            $this->viewData['tableColumns'] = [
                __( 'ID' ),
                __( 'Serial' ),
                __( 'battery' ),
                __( 'Values' ),
                __( 'measured at' ),
                 __( 'xml at' ),
                __( 'wasl at' ),
                __( 'created at' )

             ];

            $this->viewData['js_columns'] = [
                'id' => 'measurements.id',
                'serial_number' => 'measurements.serial_number',
                'battery' => 'measurements.battery',
                'values' => '',
                'measured_at' => 'measurements.measured_at',

                'xml_at' => 'measurements.xml_at',
                'wasl_at' => 'measurements.wasl_at',
                 'created_at' => 'measurements.created_at'

             ];

            $this->viewData['breadcrumb'][] = [
                'text' => __( 'measurements' )
            ];


            $this->viewData['filter'] = true;

            if ($request->withTrashed) {
                $this->viewData['pageTitle'] = __( 'Deleted measurements' );
            } else {
                $this->viewData['pageTitle'] = __( 'measurements' );
            }


            return $this->view( 'measurements', $this->viewData );
        }
    }


}
