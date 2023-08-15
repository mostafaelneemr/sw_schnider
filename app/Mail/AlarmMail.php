<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AlarmMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $alarm;
    public function __construct($alarm)
    {
        $this->alarm = $alarm;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $name = setting( 'company_name' ) ?? config( 'app.name' );
        $pdf = \PDF2::loadView( 'system.alarm-pdf', ['alarms' => $this->alarm] );
        return $this
            ->subject( 'alarms' )
            ->markdown( 'emails.repors.alarmLists' )->with( ['alarms' => $this->alarm] )
            ->attachData( $pdf->output(), date( 'Y-m-d' ) . ' - ' . $name . ' Alarm.pdf', [
                    'mime' => 'application/pdf',
                ]
            );
    }
}
