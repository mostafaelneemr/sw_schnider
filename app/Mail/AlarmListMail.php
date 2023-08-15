<?php

namespace App\Mail;

use App\Models\Alarm;
use App\Models\AlarmRules;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use niklasravnsborg\LaravelPdf\Pdf;

class AlarmListMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $alarms =   Alarm::select( [
            'sensor_id',
            'rule_id',
            'send_at',
            'status',
            'cause',
            'measurement_interval',
            'measured_at',
            'battery',
            'type',
            'value',
            'measurement',
            'comment',
            'confirmed_at',
            'confirmed_by',
            'created_at'
        ] )
            ->with( 'sensor', 'rule' )
            ->whereHas('sensor')
            ->whereHas('rule')
            ->whereRaw("DATE(created_at) >= ?",[Carbon::now()->subdays(60)])->get();
        $name = setting( 'company_name' ) ?? config( 'app.name' );
        $pdf = \PDF2::loadView( 'system.alarm-lists-pdf', ['alarms' => $alarms] );
        return $this
            ->subject( 'Ordered alarms' )
            ->markdown( 'emails.repors.alarmLists' )->with( ['alarms' => $alarms] )
            ->attachData( $pdf->output(), date( 'Y-m-d' ) . ' - ' . $name . ' Alarms list.pdf', [
                    'mime' => 'application/pdf',
                ]
            );

    }
}
