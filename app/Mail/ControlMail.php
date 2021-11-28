<?php

namespace App\Mail;

use App\Exports\HistoryExport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class ControlMail extends Mailable
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
        return $this->from('control@example.com', 'Control')
            ->subject('Control App')
            ->markdown('mail')
            ->attach(
                Excel::download(
                    new HistoryExport(),
                    'histories.xlsx'
                )->getFile(), ['as' => 'histories.xlsx']
            )
            ->with([
                'name' => 'Mirfayz',
                'link' => '/inboxes/'
            ]);
    }
}
