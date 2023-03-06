<?php

namespace App\Mail;

use App\Models\Animal;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class AnimalMailable extends Mailable
{
    use Queueable, SerializesModels;

    protected $animal;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Animal $animal)
    {
        $this->animal=$animal;
    }

    public function build()
    {
        return $this->from(Auth::user()->email, Auth::user()->name)
            ->subject('Request to adopt an animal')
            ->markdown('mailRequest')
            ->with(['animal'=>$this->animal]);
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    // public function envelope()
    // {
    //     return new Envelope(
    //         subject: 'Mailtrap Example',
    //     );
    // }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    // public function content()
    // {
        // return new Content(
        //     view: 'mailRequest',
        // );
    // }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
//     public function attachments()
//     {
//         return [];
//     }
}
