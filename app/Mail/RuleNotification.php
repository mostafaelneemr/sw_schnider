<?php

namespace App\Mail;

use App\Models\AlarmRules;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use niklasravnsborg\LaravelPdf\Pdf;

class RuleNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $rules;
    public function __construct($rules)
    {
        $this->rules = $rules;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $name = setting( 'company_name' ) ?? config( 'app.name' );
        $pdf = \PDF2::loadView( 'system.rule-notification-pdf', ['rules' => $this->rules] );
        return $this
            ->subject( 'reports' )
            ->markdown( 'emails.repors.ruleNotification' )
            ->attachData( $pdf->output(), date( 'Y-m-d' ) . ' - ' . $name . ' Rules list.pdf', [
                    'mime' => 'application/pdf',
                ]
            );

    }
}
