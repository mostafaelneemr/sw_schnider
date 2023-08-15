<?php

namespace App\Modules\Api;

use App\Http\Controllers\Controller;
use App\Mail\AlarmNotificationsMail;
use App\Mail\RuleNotification;
use App\Models\Alarm;
use App\Models\AlarmEmail;
use App\Models\Measurement;
use App\Models\MeasurementParam;
use App\Models\Sensor;
use App\Models\Serial;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;


class MeasurementApiController extends Controller
{
    public function index(Request $request)
    {
        // $one = DB::table( 'efento' )->first();

        $one = $request->all();
        $one = json_encode( $one );
        DB::table( 'efento' )->insert( ['data' => $one] );
        Serial::query()->delete();
        // dd((json_decode($one->data,1)));
        // foreach ($data as $one) {
        $measurements = (json_decode( $one, 1 ));

        foreach ($measurements as $measurement) {

            foreach ($measurement as $value) {

                $insert = [
                    'serial_number' => $value['serial'],
                    'response_handle' => $value['response_handle'],
                    'battery' => $value['battery'],
                    'signal' => $value['signal'],
                    'measurement_interval' => $value['measurement_interval'],
                    'measured_at' => Carbon::parse( $value['measured_at'] )->format( 'Y-m-d H:i' ),
                ];
                if (isset( $value['next_measured_at'] )) {
                    $insert['next_measured_at'] = Carbon::parse( $value['next_measured_at'] )->format( 'Y-m-d H:i' );
                }
                $inserted_measurement = Measurement::create( $insert );
                foreach ($value['params'] as $param) {

                    MeasurementParam::create( [
                        'measurement_id' => $inserted_measurement->id,
                        'channel' => $param['channel'],
                        'value' => $param['value'],
                        'type' => $param['type'],
                    ] );

                    $sensor = Sensor::where( 'serial_number', $value['serial'] )->whereStatus( 'active' )->first();
                    if($sensor) {
                        if ($param['type'] == 'temperature') {
                            $sensor->update(['temperature_value' => $param['value'] . ' °C']);
                        } elseif ($param['type'] == 'humidity') {
                            $sensor->update(['humidity_value' => $param['value'] . ' %']);
                        } elseif ($param['type'] == 'pressure_diff') {
                            $sensor->update(['pressure_diff_value' => $param['value'] . ' pa']);
                        }
                    }
                }

                    if (!Sensor::where( 'serial_number', $value['serial'] )->exists()) {
                        if (!Serial::where( 'serial_number', $value['serial'] )->exists()) {
                            Serial::create( ['serial_number' => $value['serial']] );
                        }
                    }



            }
        }
//        }
        header( "Content-type:application/json" );
        http_response_code( 201 );
        echo json_encode( ['Y' => [0], 'N' => []] );
        exit;
    }

    public function xml(Request $request){
        ini_set("memory_limit",-1);

        $headers = $request->header();
        DB::table( 'requests_log' )->insert(['data'=>json_encode($headers)]);
        // $measurements = Measurement::whereNull('xml_at')->with('params');
        $measurements = Measurement::
        // Join('sensors','sensors.serial_number','measurements.serial_number')
            whereIn('serial_number',Sensor::pluck('serial_number')->toArray())
            ->with('params');

        $measurements_data = clone $measurements;
        $measurements = $measurements->orderBy('measurements.measured_at','desc')->get()->unique('serial_number');
        $measurements_data->whereNull('xml_at')->update(['xml_at' =>date('Y-m-d H:i:s')]);

        $data = ['measurements'=>$measurements];
        if(isset($request->status_time) && (int)$request->status_time > 0){
            $data['status_time'] = $request->status_time;
        }else{
            $data['status_time'] = 5;
        }

        $data = view('web.xml',$data)->render();
        return '<?xml version="1.0" ?>'.$data;
    }
}
