<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactoMailable extends Mailable
{
    use Queueable, SerializesModels;
    public string $nombre, $email, $contenido;

    /**
     * Create a new message instance.
     */
    public function __construct(string $nombre, string $email, string $contenido)
    {
        $this->nombre = $nombre;
        $this->email = $email;
        $this->contenido = $contenido;
    }

    /* Get the message envelope.*/
  public function envelope(): Envelope{
      return new Envelope(
          from: new Address($this->email, $this->nombre),
          subject: 'Formulario de Contacto',);}

    /* Get the message content definition. */
  public function content(): Content{
      return new Content(
          markdown: 'emails.correo-contacto',
          with: ['nombre'=>$this->nombre,'email'=>$this->email,'contenido'=>$this->contenido]);}

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
