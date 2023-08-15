<?php

namespace App\Mail;

use App\Models\AlarmRules;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use niklasravnsborg\LaravelPdf\Pdf;

class GenerateMeasurementsChartReportMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $report;
    public $measurements;
    public $date_from;
    public $date_to;

    public function __construct($report, $measurements,$date_from,$date_to)
    {

        $this->report = $report;
        $this->measurements = $measurements;
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

        ini_set("pcre.backtrack_limit", "5000000");
        $name = $this->report->name . '_' . $this->date_from . ' _' . $this->date_to . '.pdf';
        //$pdf = \PDF2::loadView( 'system.generate-measurement-report-chart-pdf2', ['data' => $this->measurements,'name'=>$name,'date_from'=>$this->date_from,'date_to'=>$this->date_to] );
        $pdf = \PDFSalman::loadHTML( view('system.generate-measurement-report-chart-pdf2',
            ['data' => $this->measurements,'name'=>$name,'date_from'=>$this->date_from,'date_to'=>$this->date_to,'auth_name'=>auth()->user()->name,'sensor'=>$this->report] )->render());
        $pdf->setPaper(array(0,0,909,800), 'portrait');
        return $this
            ->subject( 'New Report' )
            ->markdown( 'emails.repors.alarmLists' )
            ->attachData( $pdf->output(), $name, [
                    'mime' => 'application/pdf',
                ]
            );

    }



}
