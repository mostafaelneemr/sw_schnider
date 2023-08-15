<?php

namespace App\Mail;

use App\Models\AlarmRules;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use niklasravnsborg\LaravelPdf\Pdf;

class AlarmNotificationsMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $name = setting( 'company_name' ) ?? config( 'app.name' );
        $pdf = \PDF2::loadView( 'system.rule-notification-pdf', ['rules' => AlarmRules::all()] );
        return $this
            ->subject( 'reports' )
            ->markdown( 'emails.repors.alarmNotifications' )
            ->attachData( $pdf->output(), date( 'Y-m-d' ) . ' - ' . $name . ' Rules list.pdf', [
                    'mime' => 'application/pdf',
                ]
            );

    }
}
