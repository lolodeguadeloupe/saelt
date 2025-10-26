<?php

namespace App\Notifications;

use App\Exports\GeneratePDF;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\HtmlString;

class FactureNotification extends Notification 
{
    use Queueable;
    private $data;
    private $action;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data, $action)
    {
        $this->data = $data;
        $this->action = $action;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $notifice = (new MailMessage)
            ->subject('Facturation et voucher - ' . $this->data['id'])
            ->greeting('Bonjour Madame, Monsieur ' . $this->data['client'] . ',')
            ->line('Veuillez trouver ci-joint votre avis d’opération.')
            ->line('Saelt Voyages vous remercie de votre confiance et vous souhaite un excellent séjour dans nos îles.')
            ->salutation(new HtmlString('Votre conseiller voyage,<br>' . config('app.name')));
        foreach ($this->data['voucher'] as $key => $value) {
            $notifice->attach($value->file_pdf);
        }
        return $notifice->attach($this->data['facture']);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return $this->data;
    }

    public function __destruct()
    {
        foreach ($this->data['voucher'] as $key => $value) {
            GeneratePDF::delete_doc($value->file_pdf);
        }
        GeneratePDF::delete_doc($this->data['facture']);
    }
}
