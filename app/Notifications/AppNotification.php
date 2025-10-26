<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class AppNotification extends Notification
{
    use Queueable;
    private $reference;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($reference)
    {
        $this->reference = $reference;
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
        return (new MailMessage)
            ->subject('Commande d\'un client')
            ->greeting('Bonjour Madame, Monsieur')
            ->line(' un client vient de valider ses commandes')
            ->salutation(new HtmlString('À bientôt,<br>' . config('app.name')))
            ->line(new HtmlString( '<b><i>Réference commande</i></b> : ' . $this->reference . '<br>'
            ));

    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'reference' => $this->reference,
        ];
    }
}
