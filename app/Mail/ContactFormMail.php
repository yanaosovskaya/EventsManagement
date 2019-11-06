<?php

namespace App\Mail;

use App\Http\Requests\ContactFormRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new message instance.
     *
     * @param ContactFormRequest $request
     */
    public function __construct(ContactFormRequest $request)
    {
        $this->data = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $from = setting('contact_form_from');

        return $this->markdown('emails.contact-form')
            ->from(env('ADMIN_MAIL'), $from)
            ->with([
                'data' => $this->data,
            ]);
    }
}
