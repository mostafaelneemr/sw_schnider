<?php

namespace App\Mail;

use App\Models\AlarmRules;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use niklasravnsborg\LaravelPdf\Pdf;

class GenerateAlarmsReportMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $sensor;
    public $alarms;
    public $date_from;
    public $date_to;

    public function __construct($sensor, $alarms,$date_from,$date_to)
    {

        $this->sensor = $sensor;
        $this->alarms = $alarms;
        $this->date_from = $date_from;
        $this->date_to = $date_to;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $name = $this->sensor->name . '_' . $this->date_from . ' _' . $this->date_to . '.pdf';
        $pdf = \PDF2::loadView( 'system.generate-alarm-report-pdf', ['alarms' => $this->alarms,'name'=>$name,'date_from'=>$this->date_from,'date_to'=>$this->date_to,'sensor'=>$this->sensor] );
        return $this
            ->subject( 'New Report' )
            ->markdown( 'emails.repors.alarmLists' )
            ->attachData( $pdf->output(), $name, [
                    'mime' => 'application/pdf',
                ]
            );

    }
}