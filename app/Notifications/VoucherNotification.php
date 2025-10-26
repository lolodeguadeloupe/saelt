<?php

namespace App\Notifications;

use App\Exports\GeneratePDF;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\HtmlString;

class VoucherNotification extends Notification
{
    use Queueable;
    private $data;
    private $name;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data, $name)
    {
        $this->data = $data;
        $this->name = $name;
    }

    public function __destruct()
    {
        foreach ($this->data as $key => $value) {
            GeneratePDF::delete_doc($value->file_pdf);
        }
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
        $notif = (new MailMessage)
            ->subject('Voucher-' . now())

            ->greeting('Bonjour, ' . $this->name)
            ->line('Un client vient de commander des produts, veuillez trouver ci joint le bon de commandes');

        $html = "<ul>";
        foreach ($this->data as $key => $value) {
            $html .= "<li><b>" . ($key + 1) . " - </b><i>" . $value->titre . "</i></li>";
        }
        $html .= "</ul>";

        $notif->line(new HtmlString($html))
            ->line('Saelt Voyages vous remercie de votre confiance !')
            ->salutation(new HtmlString('Cordialement,<br>' . config('app.name')));
        foreach ($this->data as $key => $value) {
            $notif->attach($value->file_pdf);
        }
        return $notif;
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
}
