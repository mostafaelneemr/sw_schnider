<?php

namespace App\Console;

use App\Mail\AlarmListMail;
use App\Mail\AlarmMail;
use App\Mail\AutomaticReportMail;
use App\Mail\GenerateMeasurementsAtomaticReportMail;
use App\Mail\GenerateMeasurementsReportMail;
use App\Models\Alarm;
use App\Models\AlarmEmail;
use App\Models\AutomaticReport;
use App\Models\Measurement;
use App\Models\Sensor;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $time_from_settings = setting( 'send_emails_at' ) ? setting( 'send_emails_at' ) : "2:02";
        $schedule->call( function () {
            $automaticReports = AutomaticReport::whereStatus( 1 )->where( 'schedule', '=', 'daily' )->get();
            if ($automaticReports->isNotEmpty()) {
                foreach ($automaticReports as $report) {
                    $date_from = Carbon::now()->subDay()->format( 'Y-m-d' );
                    $date_to = Carbon::now()->subDay()->format( 'Y-m-d' );
                    $sensor_serial_numbers = $report->sensors()->pluck( 'serial_number' );
                    $res = $report->recipients()->pluck( 'value' );
                    if (in_array( 'Measurements', $report->report_contain )) {
                        $measurements_data = Measurement::whereIn( 'serial_number', $sensor_serial_numbers )->whereHas( 'params' )->with( 'params' )
                            ->whereRaw( "DATE(measurements.created_at) >= ?", [Carbon::now()->subdays()] );
                        $measurements = $measurements_data->orderBy( 'measured_at', 'desc' );

                        $measurements = $measurements->limit( 3800 )->get()->groupBy( 'serial_number' );
                        if ($measurements->isNotEmpty()) {
                            Mail::to( $res )
                                ->queue( new GenerateMeasurementsAtomaticReportMail( $report, $measurements->toArray(), $date_from, $date_to ) );
                        }
                    } else {
                        $sensor_ids = $report->sensors()->pluck( 'id' );

                        $alarms = Alarm::with( 'sensor', 'rule' )->whereIn( 'sensor_id', $sensor_ids );
                        whereBetween( $alarms, "DATE(measured_at) ", $date_from, $date_to );
                        $alarms = $alarms->get()->groupBy( 'sensor_id' );
                        if ($alarms->isNotEmpty()) {
                            Mail::to( $res )
                                ->send( new AutomaticReportMail( $report, $alarms->toArray(), $date_from, $date_to ) );
                        }
                    }
                }
            }


        } )->dailyAt( $time_from_settings );

        $schedule->call( function () {
            $automaticReports = AutomaticReport::whereStatus( 1 )->where( 'schedule', '=', 'Weekly' )->get();
            if ($automaticReports->isNotEmpty()) {
                foreach ($automaticReports as $report) {
                    $res = $report->recipients()->pluck( 'value' );
                    $date_to = Carbon::now()->subDays( 8 )->format( 'Y-m-d' );
                    $date_from = Carbon::now()->subDay()->format( 'Y-m-d' );
                    $sensor_serial_numbers = $report->sensors()->pluck( 'serial_number' );
                    if (in_array( 'Measurements', $report->report_contain )) {
                        $measurements_data = Measurement::whereIn( 'serial_number', $sensor_serial_numbers )->whereHas( 'params' )->with( 'params' );
                        whereBetween( $measurements_data, "DATE(measurements.created_at) ", $date_from, $date_to );
                        $measurements = $measurements_data->orderBy( 'measured_at', 'desc' );
                        $measurements = $measurements->limit( 3800 )->get()->groupBy( 'serial_number' );
                        if ($measurements->isNotEmpty()) {
                            Mail::to( $res )
                                ->queue( new GenerateMeasurementsAtomaticReportMail( $report, $measurements->toArray(), $date_from, $date_to ) );
                        }
                    } else {
                        $sensor_ids = $report->sensors()->pluck( 'id' );

                        $alarms = Alarm::
                        with( 'sensor', 'rule' )->
                        whereIn( 'sensor_id', $sensor_ids );
                        whereBetween( $alarms, "DATE(measured_at) ", $date_from, $date_to );
                        $alarms = $alarms->get()->groupBy( 'sensor_id' );
                        if ($alarms->isNotEmpty()) {
                            Mail::to( $res )
                                ->send( new AutomaticReportMail( $report, $alarms->toArray(), $date_from, $date_to ) );
                        }
                    }
                }
            }
        } )->weeklyOn( 2, $time_from_settings );

        $schedule->call( function () {
            $automaticReports = AutomaticReport::whereStatus( 1 )->where( 'schedule', '=', 'monthly' )->get();
            if ($automaticReports->isNotEmpty()) {
                foreach ($automaticReports as $report) {
                    $res = $report->recipients()->pluck( 'value' );
                    $date_to = Carbon::now()->subDays( 30 )->format( 'Y-m-d' );
                    $date_from = Carbon::now()->subDay()->format( 'Y-m-d' );
                    $sensor_serial_numbers = $report->sensors()->pluck( 'serial_number' );
                    if (in_array( 'Measurements', $report->report_contain )) {
                        $measurements_data = Measurement::whereIn( 'serial_number', $sensor_serial_numbers )->whereHas( 'params' )->with( 'params' );
                        whereBetween( $measurements_data, "DATE(measurements.created_at) ", $date_from, $date_to );
                        $measurements = $measurements_data->orderBy( 'measured_at', 'desc' );
                        $measurements = $measurements->limit( 3800 )->get()->groupBy( 'serial_number' );
                        if ($measurements->isNotEmpty()) {
                            Mail::to( $res )
                                ->queue( new GenerateMeasurementsAtomaticReportMail( $report, $measurements->toArray(), $date_from, $date_to ) );
                        }
                    } else {
                        $alarms = Alarm::with( 'sensor', 'rule' )->whereIn( 'sensor_id', $sensor_ids );
                        $sensor_ids = $report->sensors()->pluck( 'id' );
                        whereBetween( $alarms, "DATE(measured_at) ", $date_from, $date_to );
                        $alarms = $alarms->get()->groupBy( 'sensor_id' );
                        if ($alarms->isNotEmpty()) {
                            Mail::to( $res )
                                ->send( new AutomaticReportMail( $report, $alarms->toArray(), $date_from, $date_to ) );
                        }
                    }
                }
            }
        } )->monthlyOn( 1, $time_from_settings );
        $schedule->call( function () {
            $alarmEmails = AlarmEmail::where( 'sent', '=', "0" )
                ->where( function ($q) {
                    $q->where( 'send_at', '=', 'immediately' )
                        ->orWhere( 'send_at', '<=', Carbon::now() );
                } )->get();
            if ($alarmEmails->isNotEmpty()) {
                $res = [];
                foreach ($alarmEmails->pluck( 'recipients' ) as $one) {
                    $res = array_unique( array_merge( $res, $one ) );
                }
                $alarms = Alarm::whereIn( 'id', $alarmEmails->pluck( 'alarm_id' ) )->get();
                Mail::to( $res )->send( new AlarmMail( $alarms ) );
            }
            AlarmEmail::where( 'sent', '=', "0" )
                ->where( function ($q) {
                    $q->where( 'send_at', '=', 'immediately' )
                        ->orWhere( 'send_at', '<=', Carbon::now() );
                } )->update( ['sent' => "1"] );
        } )->everyMinute();

        $schedule->call( function () {
            $sesnors = Sensor::where( 'status', 'active' )->where( function ($query) {
                $query->where( 'alarm_status', '!=', 'Lost' )
                    ->orWhereNull( 'alarm_status' );
            } )->get();
            foreach ($sesnors as $sesnor) {
                $measurement = Measurement::where( 'serial_number', $sesnor->serial_number )->latest()->first();
                if ($measurement) {
                    $seconds = $measurement->measurement_interval * 3;
                    if (Carbon::now() > Carbon::parse( $measurement->created_at )->addSeconds( $seconds )) {
                        $sesnor->update( ['alarm_status' => 'Lost'] );
                    }
                }
            }
        } )->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load( __DIR__ . '/Commands' );

        require base_path( 'routes/console.php' );
    }
}
