<?php

namespace App\Mail;

use App\Models\AlarmRules;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use niklasravnsborg\LaravelPdf\Pdf;

class AutomaticReportMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $report;
    public $alarms;
    public $date_from;
    public $date_to;

    public function __construct($report, $alarms,$date_from,$date_to)
    {

        $this->report = $report;
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
        $name = $this->report->name . '_' . $this->date_from . ' _' . $this->date_to . '.pdf';
        $pdf = \PDF2::loadView( 'system.automatic-report-pdf', ['alarms' => $this->alarms,'name'=>$name,'date_from'=>$this->date_from,'date_to'=>$this->date_to] );
        return $this
            ->subject( 'Automatic Reports' )
            ->markdown( 'emails.repors.alarmLists' )
            ->attachData( $pdf->output(), $name, [
                    'mime' => 'application/pdf',
                ]
            );

    }
}
