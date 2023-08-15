<?php

namespace App\Modules\System;

use App\Mail\AlarmListMail;
use App\Mail\GenerateAlarmsReportMail;
use App\Mail\GenerateMeasurementsChartReportMail;
use App\Mail\GenerateMeasurementsReportMail;
use Carbon\Carbon;
use App\Models\{CloudUsers, Location, MapView, Measurement, PermissionGroup, Sensor, Serial};
use Illuminate\Http\Request;
use Datatables;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class SensorController extends SystemController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->isDataTable) {

            $eloquentData = Sensor::select( [
                'name',
                'serial_number',
                'location_id',
                'created_by',
                'created_at'
            ] )
                ->with( 'location', 'createdBy' );

            if ($request->id) {
                $eloquentData->where( 'id', '=', $request->id );
            }

            if ($request->name) {
                $eloquentData->where( function ($query) use ($request) {
                    $query->where( 'name', 'LIKE', '%' . $request->name . '%' );
                } );
            }

            if ($request->email) {
                $eloquentData->where( 'email', 'LIKE', '%' . $request->email . '%' );
            }

            if ($request->subdomain) {
                $eloquentData->where( 'subdomain', 'LIKE', '%' . $request->subdomain . '%' );
            }

            if ($request->mobile) {
                $eloquentData->where( 'mobile', 'LIKE', '%' . $request->mobile . '%' );
            }

            if ($request->type) {
                $eloquentData->where( 'type', '=', $request->type );
            }

            if ($request->downloadExcel == "true") {

                $excelData = $eloquentData;
                $excelData = $excelData->get();
                return exportXLS( __( 'CloudUsers' ),
                    [
                        __( 'ID' ),
                        __( 'Name' ),
                        __( 'Email' ),
                        __( 'Mobile' ),
                        __( 'SubDomain' ),
                        __( 'Type' ),
                    ],
                    $excelData,
                    [
                        'id' => 'id',
                        'name' => 'name',
                        'email' => 'email',
                        'mobile' => 'mobile',
                        'subdomain' => 'subdomain',
                        'type' => 'type'
                    ]
                );
            }

            return Datatables::of( $eloquentData )
                ->addColumn( 'serial_number', '{{$serial_number}}' )
                ->addColumn( 'name', '{{$name}}' )
                ->addColumn( 'subdomain', function ($data) {
                    return $data->subdomain;
                } )
                ->addColumn( 'type', function ($data) {
                    if ($data->type == 'admin') {
                        return '<span class="k-badge  k-badge--success k-badge--inline k-badge--pill">' . __( 'Admin' ) . '</span>';
                    }
                    return '<span class="k-badge  k-badge--danger k-badge--inline k-badge--pill">' . __( 'Driver' ) . '</span>';
                } )
                ->addColumn( 'action', function ($data) {
                    return '<span class="dropdown">
                            <a href="#" class="btn btn-md btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="false">
                              <i class="la la-gear"></i>
                            </a>
                            <div class="dropdown-menu ' . ((\App::getLocale() == 'ar') ? 'dropdown-menu-left' : 'dropdown-menu-right') . '" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-36px, 25px, 0px);">
                                <a class="dropdown-item" href="' . route( 'system.cloud-users.show', $data->id ) . '" target="_blank"><i class="far fa-eye"></i> ' . __( 'View' ) . '</a>
                                <a class="dropdown-item" href="' . route( 'system.cloud-users.edit', $data->id ) . '"><i class="la la-edit"></i> ' . __( 'Edit' ) . '</a>
                               <!--  <a class="dropdown-item" href="javascript:void(0);" onclick="deleteRecord(\'' . route( 'system.cloud-users.destroy', $data->id ) . '\')"><i class="la la-trash-o"></i> ' . __( 'Delete' ) . '</a> -->
                            </div>
                        </span>';
                } )
                ->escapeColumns( [] )
                ->make( true );
        } else {
            // View Data
            $this->viewData['tableColumns'] = [
                __( 'ID' ),
                __( 'Name' ),
                __( 'Email' ),
                __( 'Mobile' ),
                __( 'SubDomain' ),
                __( 'Type' ),
                __( 'Action' )
            ];

            $this->viewData['js_columns'] = [
                'id' => 'cloud_users.id',
                'name' => 'cloud_users.name',
                'email' => 'cloud_users.email',
                'mobile' => 'cloud_users.mobile',
                'subdomain' => 'cloud_users.subdomain',
                'type' => 'cloud_users.type',
                'action' => 'action'
            ];

            $this->viewData['breadcrumb'][] = [
                'text' => __( 'CloudUsers' )
            ];

            $this->viewData['add_new'] = [
                'text' => __( 'Add CloudUsers' ),
                'route' => 'system.staff.create'
            ];
            $this->viewData['filter'] = true;
            $this->viewData['download_excel'] = true;

            if ($request->withTrashed) {
                $this->viewData['pageTitle'] = __( 'Deleted CloudUsers' );
            } else {
                $this->viewData['pageTitle'] = __( 'CloudUsers' );
            }

            return $this->view( 'sensors.index', $this->viewData );
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (setting( 'number_of_sensors' ) <= Sensor::count()) {
            return redirect()->to( route( 'system.dashboard' ) )->with( 'error', __( 'Sorry, we could not add the data,upgrade your subscription' ) );
        }
        $this->viewData['breadcrumb'][] = [
            'text' => __( 'Sensor' ),
            'url' => route( 'system.dashboard' )
        ];

        $this->viewData['breadcrumb'][] = [
            'text' => __( 'Create Sensor' ),
        ];

        $this->viewData['pageTitle'] = __( 'Create Sensor' );
        $this->viewData['locations'] = array_column( Location::all()->toArray(), 'name', 'id' );
        $this->viewData['serials'] = array_column( Serial::all()->toArray(), 'serial_number', 'serial_number' );
        return $this->view( 'sensors.create', $this->viewData );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (setting( 'number_of_sensors' ) <= Sensor::count()) {
            return redirect()->to( route( 'system.dashboard' ) )->with( 'error', __( 'Sorry, we could not add the data , upgrade your subscription' ) );
        }
        $request->validate( [
            'name' => 'required',
            'serial_number' => 'required|unique:sensors,serial_number',
            'location_id' => 'required|exists:locations,id',
        ] );
        $requestData = $request->only( 'name', 'serial_number', 'location_id' );
        $requestData['created_by'] = auth()->id();
        $requestData['location_name'] = Location::find( $request->location_id )->name;
        if (Serial::where( 'serial_number', $request->serial_number )->exists()) {
            Serial::where( 'serial_number', $request->serial_number )->delete();
        }
        $insertData = Sensor::create( $requestData );
        if ($insertData) {
            return $this->response(
                true,
                200,
                __( 'Data added successfully' ),
                [
                    'url' => route( 'system.dashboard' )
                ]
            );
        } else {
            return $this->response(
                false,
                11001,
                __( 'Sorry, we could not add the data' )
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(Sensor $sensor, Request $request)
    {


        $this->viewData['breadcrumb'] = [
            [
                'text' => __( 'Sensors' ),
                'url' => route( 'system.dashboard' ),
            ],
            [
                'text' => $sensor->name,
            ]
        ];

        $this->viewData['pageTitle'] = __( 'Sensors' );

        $this->viewData['result'] = $sensor->alarms()->limit( 10 )->get();
        $this->viewData['id'] = $sensor->id;
        $this->viewData['sensor'] = $sensor;
        $this->viewData['locations'] = array_column( Location::all()->toArray(), 'name', 'id' );
        return $this->view( 'sensors.calendar', $this->viewData );

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(CloudUsers $staff, Request $request)
    {

        // Main View Vars
        $this->viewData['breadcrumb'][] = [
            'text' => __( 'CloudUsers' ),
            'url' => route( 'system.cloud-users.index' )
        ];

        $this->viewData['breadcrumb'][] = [
            'text' => __( 'Edit (:name)', ['name' => $staff->fullname] ),
        ];

        $this->viewData['pageTitle'] = __( 'Edit CloudUsers' );
        $this->viewData['result'] = $staff;
        $this->viewData['PermissionGroup'] = PermissionGroup::get();

        return $this->view( 'cloud-users.create', $this->viewData );

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sensor $sensor)
    {
        $request->validate( [
            'name' => 'required',
            'serial_number' => 'required|unique,sensors:serial_number',
            'location_id' => 'required',
            'type' => 'required'
        ] );
        $requestData = $request->all();
        $updateData = $sensor->update( $requestData );

        if ($updateData) {
            return $this->response(
                true,
                200,
                __( 'Data modified successfully' ),
                [
                    'url' => route( 'system.dashboard' )
                ]
            );
        } else {
            return $this->response(
                false,
                11001,
                __( 'Sorry, we could not edit the data' )
            );
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sensor $sensor, Request $request)
    {
        $message = __( 'Sensor deleted successfully' );

        $sensor->delete();
        return $this->response( true, 200, $message );
    }

    public function updateStatus(Request $request, Sensor $sensor)
    {
        if ($sensor->status == 'active') {
            $sensor->update( ['status' => 'in-active'] );
            $status = 'Enable';
        } else {
            $sensor->update( ['status' => 'active'] );
            $status = 'Disable';
        }
        if ($request->ajax()) {
            return ['status' => true, 'status_text' => $status, 'msg' => __( 'Sensor Status has been Updated successfully' )];
        }
    }

    public function updateLocation(Request $request)
    {
        $validator = Validator::make( $request->all(), [
            'location_id' => 'required|exists:locations,id'
        ] );
        if ($validator->fails()) {
            return $this->ValidationError( $validator, __( 'Validation Error' ) );
        }
        $sensor = Sensor::find( $request->sensor_id );
        $location = Location::find( $request->location_id );
        $sensor->update( ['location_id' => $request->location_id, 'location_name' => $location->name] );
        if ($request->ajax()) {
            return ['status' => true, 'msg' => __( 'Sensor Location has been Updated successfully' )];
        }
    }

    public function updateName(Request $request)
    {
        $validator = Validator::make( $request->all(), [
            'name' => 'required'
        ] );
        if ($validator->fails()) {
            return $this->ValidationError( $validator, __( 'Validation Error' ) );
        }

        $sensor = Sensor::find( $request->sensor_id );
        $sensor->update( ['name' => $request->name] );
        if ($request->ajax()) {
            return ['status' => true, 'name' => $sensor->name, 'msg' => __( 'Sensor Name has been Updated successfully' )];
        }
    }

    public function sensorChart(Sensor $sensor, Request $request)
    {
        if (empty( $request->from )) {
            $request->from = date( 'Y-m-d' );
        //            $request->from ='2021-06-05';
        }
        if (empty( $request->to )) {
            $request->to = date( 'Y-m-d' );
        //            $request->to ='2021-06-05';
        }

        $measurements = Measurement::where( 'serial_number', $sensor->serial_number )
            ->join( 'measurement_params', 'measurements.id', '=', 'measurement_params.measurement_id' )
            ->whereRaw( "DATE(created_at) >= ?", [Carbon::now()->subdays( 35 )] );
        whereBetween( $measurements, 'DATE(created_at)', $request->from, $request->to );
        $measurements = $measurements->orderBy( 'measured_at', 'desc' )->get();
        if (count( $sensor->alarmRules )) {
            $humidity_min = $sensor->alarmRules()->where( 'condition_name', 'humidity' )->min( 'condition_value' );
            $humidity_max = $sensor->alarmRules()->where( 'condition_name', 'humidity' )->max( 'condition_value' );
            $temperature_min = $sensor->alarmRules()->where( 'condition_name', 'temperature' )->min( 'condition_value' );
            $temperature_max = $sensor->alarmRules()->where( 'condition_name', 'temperature' )->min( 'condition_value' );
        } else {
            $humidity_min = $measurements->where( 'type', 'humidity' )->min( 'value' );
            $humidity_max = $measurements->where( 'type', 'humidity' )->max( 'value' );
            $temperature_min = $measurements->where( 'type', 'temperature' )->min( 'value' );
            $temperature_max = $measurements->where( 'type', 'temperature' )->max( 'value' );
        }
        $data['humidity_min'] = $humidity_min;
        $data['humidity_max'] = $humidity_max;
        $data['temperature_min'] = $temperature_min;
        $data['temperature_max'] = $temperature_max;
        $data['measurements'] = $measurements->groupBy( 'type' );
        $data['rule'] = $sensor->alarmRules()->whereIn( 'condition_name', ['humidity', 'temperature'] )->select( ['condition_name', 'condition_value', 'degree_value', 'name', 'condition_type'] )->without( 'pivot' )->get();
        return response()->json( $data );
    }

    public function image()
    {
        return $this->view( 'image', $this->viewData );
    }

    public function sensorDetailsRules(Sensor $sensor, Request $request)
    {
        $data = [];


        $chanel1 = Measurement::where( 'serial_number', $sensor->serial_number )
            ->where( 'measurement_params.channel', '=', 1 )
            ->join( 'measurement_params', 'measurements.id', '=', 'measurement_params.measurement_id' );
        $chanel2 = Measurement::where( 'serial_number', $sensor->serial_number )
            ->where( 'measurement_params.channel', '=', 2 )
            ->join( 'measurement_params', 'measurements.id', '=', 'measurement_params.measurement_id' );

        whereBetween( $chanel1, 'DATE(measurements.created_at)', $request->from, $request->to );
        whereBetween( $chanel2, 'DATE(measurements.created_at)', $request->from, $request->to );

        $rules = $sensor->alarmRules;
        $data['rules'] = $rules;
        $data['slot1_max'] = $chanel1->max( 'value' ) ?? '0.0';
        $data['slot2_max'] = $chanel2->max( 'value' ) ?? '0.0';
        $data['slot1_min'] = $chanel1->min( 'value' ) ?? '0.0';
        $data['slot2_min'] = $chanel2->min( 'value' ) ?? '0.0';
        $data['slot1_avg'] = number_format( $chanel1->avg( 'value' ), 2 );
        $data['slot2_avg'] = number_format( $chanel2->avg( 'value' ), 2 );

        return response()->json( $data );

    }

    public function sensorDetailsAlarms(Sensor $sensor, Request $request)
    {
        $alarms = $sensor->alarms()->whereHas( 'rule' )->select( ['id', 'sensor_id', 'cause', 'created_at', 'status'] )
            ->whereRaw( "DATE(created_at) >= ?", [Carbon::now()->subdays( 35 )] );
        whereBetween( $alarms, 'DATE(created_at)', $request->from, $request->to );
        return response()->json( $alarms->get() );
    }

    public function sensorDetailsMeasurements(Sensor $sensor, Request $request)
    {
        $measurements_data = Measurement::where( 'serial_number', $sensor->serial_number )
            ->join( 'measurement_params', 'measurements.id', '=', 'measurement_params.measurement_id' )
            ->whereRaw( "DATE(measurements.created_at) >= ?", [Carbon::now()->subdays( 35 )] );
        $measurements = $measurements_data->orderBy( 'measured_at', 'desc' );

        whereBetween( $measurements, 'DATE(measurements.created_at)', $request->from, $request->to );
        return response()->json( $measurements->limit( 3800 )->get()->groupBy( 'type' ) );
    }

    public function GenerateReport(Request $request, Sensor $sensor)
    {

        $validator = Validator::make( $request->all(), [
            'report_contain' => 'required',
            'report_extension' => 'required',
            'date' => 'required',
        ] );
        if ($validator->fails()) {
            return $this->ValidationError( $validator, __( 'Validation Error' ) );
        }
        $dates = explode( '-', $request->date );
        //$request->chart
        if ($request->report_extension =='chart') {
            if (in_array( 'Measurements', $request->report_contain ) ) {
                $measurements_data = Measurement::where( 'serial_number', $sensor->serial_number )
                    ->join( 'measurement_params', 'measurements.id', '=', 'measurement_params.measurement_id' )
                    ->whereRaw( "DATE(measurements.created_at) >= ?", [Carbon::now()->subdays( 35 )] );
                $measurements = $measurements_data->orderBy( 'measured_at', 'desc' );
                whereBetween( $measurements, 'created_at', Carbon::parse( $dates[0] )->format( 'Y-m-d H:i' ), Carbon::parse( $dates[1] )->format( 'Y-m-d H:i' ) );
                $measurements = $measurements->orderBy( 'measured_at', 'desc' )->limit( 350 )->get();
                if (!$measurements->count()) {
                    $humidity_min = $sensor->alarmRules()->where( 'condition_name', 'humidity' )->min( 'condition_value' );
                    $humidity_max = $sensor->alarmRules()->where( 'condition_name', 'humidity' )->max( 'condition_value' );
                    $humidity_avg = $sensor->alarmRules()->where( 'condition_name', 'humidity' )->avg( 'condition_value' );
                    $temperature_min = $sensor->alarmRules()->where( 'condition_name', 'temperature' )->min( 'condition_value' );
                    $temperature_max = $sensor->alarmRules()->where( 'condition_name', 'temperature' )->min( 'condition_value' );
                    $temperature_avg = $sensor->alarmRules()->where( 'condition_name', 'temperature' )->avg( 'condition_value' );
                } else {
                    $humidity_min = $measurements->where( 'type', 'humidity' )->min( 'value' );
                    $humidity_max = $measurements->where( 'type', 'humidity' )->max( 'value' );
                    $humidity_avg = $measurements->where( 'type', 'humidity' )->avg( 'value' );
                    $temperature_min = $measurements->where( 'type', 'temperature' )->min( 'value' );
                    $temperature_max = $measurements->where( 'type', 'temperature' )->max( 'value' );
                    $temperature_avg = $measurements->where( 'type', 'temperature' )->avg( 'value' );
                }
                $data['humidity_min'] = number_format( $humidity_min, 1 );
                $data['humidity_max'] = number_format( $humidity_max, 1 );
                $data['humidity_avg'] = number_format( $humidity_avg, 1 );
                $data['temperature_min'] = number_format( $temperature_min, 1 );
                $data['temperature_max'] = number_format( $temperature_max, 1 );
                $data['temperature_avg'] = number_format( $temperature_avg, 1 );
                $data['humidity_rules'] = $sensor->alarmRules()->where( 'condition_name', 'humidity' )->get();
                $data['temperature_rules'] = $sensor->alarmRules()->where( 'condition_name', 'temperature' )->get();

                $data['measurements'] = $measurements->groupBy( 'type' );
                Mail::to( auth()->user()->email )
                    ->queue( new GenerateMeasurementsChartReportMail( $sensor, $data, Carbon::parse( $dates[0] )->format( 'Y-m-d' ), Carbon::parse( $dates[1] )->format( 'Y-m-d' ) ) );
                return ['status' => true, 200, 'msg' => __( 'Report sent successfully,It will be delivered in seconds' )];
            }
            if (in_array( 'Alarms', $request->report_contain ) || in_array( 'Technical details', $request->report_contain )) {
                $alarms = $sensor->alarms()->select( ['id', 'sensor_id', 'cause', 'created_at', 'status'] )
                    ->whereRaw( "DATE(created_at) >= ?", [Carbon::now()->subdays( 35 )] );
                whereBetween( $alarms, 'created_at', Carbon::parse( $dates[0] )->format( 'Y-m-d H:i' ), Carbon::parse( $dates[1] )->format( 'Y-m-d H:i' ) );
                Mail::to( auth()->user()->email )
                    ->queue( new GenerateAlarmsReportMail( $sensor, $alarms->get(), Carbon::parse( $dates[0] )->format( 'Y-m-d' ), Carbon::parse( $dates[1] )->format( 'Y-m-d' ) ) );
                return ['status' => true, 200, 'msg' => __( 'Report sent successfully,It will be delivered in seconds' )];
            }
        }else{

            if (in_array( 'Measurements', $request->report_contain ) ) {
                $measurements_data = Measurement::where( 'serial_number', $sensor->serial_number )->with( 'params' )
                    ->whereRaw( "DATE(measurements.created_at) >= ?", [Carbon::now()->subdays( 35 )] );

                whereBetween( $measurements_data, 'created_at', Carbon::parse( $dates[0] )->format( 'Y-m-d H:i' ), Carbon::parse( $dates[1] )->format( 'Y-m-d H:i' ) );

                $measurements = $measurements_data->orderBy( 'measured_at', 'desc' )->limit( 350 )->get();
                if (!$measurements->count()) {
                    $humidity_min = $sensor->alarmRules()->where( 'condition_name', 'humidity' )->min( 'condition_value' );
                    $humidity_max = $sensor->alarmRules()->where( 'condition_name', 'humidity' )->max( 'condition_value' );
                    $humidity_avg = $sensor->alarmRules()->where( 'condition_name', 'humidity' )->avg( 'condition_value' );
                    $temperature_min = $sensor->alarmRules()->where( 'condition_name', 'temperature' )->min( 'condition_value' );
                    $temperature_max = $sensor->alarmRules()->where( 'condition_name', 'temperature' )->min( 'condition_value' );
                    $temperature_avg = $sensor->alarmRules()->where( 'condition_name', 'temperature' )->avg( 'condition_value' );
                } else {
                    $humidity_min = $measurements->where( 'type', 'humidity' )->min( 'value' );
                    $humidity_max = $measurements->where( 'type', 'humidity' )->max( 'value' );
                    $humidity_avg = $measurements->where( 'type', 'humidity' )->avg( 'value' );
                    $temperature_min = $measurements->where( 'type', 'temperature' )->min( 'value' );
                    $temperature_max = $measurements->where( 'type', 'temperature' )->max( 'value' );
                    $temperature_avg = $measurements->where( 'type', 'temperature' )->avg( 'value' );
                }
                $data['humidity_min'] =     number_format($humidity_min,1);
                $data['humidity_max'] =     number_format($humidity_max,1);
                $data['humidity_avg'] =     number_format($humidity_avg,1);
                $data['temperature_min'] =  number_format($temperature_min,1);
                $data['temperature_max'] =  number_format($temperature_max,1);
                $data['temperature_avg'] =  number_format($temperature_avg,1);

                $data['measurements'] = $measurements->groupBy( 'type' );

                Mail::to( auth()->user()->email )
                    ->queue( new GenerateMeasurementsReportMail( $sensor, $measurements->limit( 3800 )->get(), Carbon::parse( $dates[0] )->format( 'Y-m-d' ), Carbon::parse( $dates[1] )->format( 'Y-m-d' ) ) );
                return ['status' => true, 200, 'msg' => __( 'Report sent successfully,It will be delivered in seconds' )];
            }
            if (in_array( 'Alarms', $request->report_contain ) || in_array( 'Technical details', $request->report_contain )) {
                $alarms = $sensor->alarms()->select( ['id', 'sensor_id', 'cause', 'created_at', 'status'] )
                    ->whereRaw( "DATE(created_at) >= ?", [Carbon::now()->subdays( 35 )] );
                whereBetween( $alarms, 'created_at', Carbon::parse( $dates[0] )->format( 'Y-m-d H:i' ), Carbon::parse( $dates[1] )->format( 'Y-m-d H:i' ) );
                Mail::to( auth()->user()->email )
                    ->queue( new GenerateAlarmsReportMail( $sensor, $alarms->get(), Carbon::parse( $dates[0] )->format( 'Y-m-d' ), Carbon::parse( $dates[1] )->format( 'Y-m-d' ) ) );
                return ['status' => true, 200, 'msg' => __( 'Report sent successfully,It will be delivered in seconds' )];
            }
        }
    }

}
