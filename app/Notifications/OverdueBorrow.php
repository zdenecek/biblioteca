<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OverdueBorrow extends Notification
{
    use Queueable;

    public $borrows;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($borrows)
    {
        $this->borrows = $borrows;
    }
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
        ->subject(count($this->borrows) > 1 ? 'Nevrácené knihy' : 'Nevrácená kniha')
        ->line('Tento email jste dostali, protože Vám vypršela knihovní výpůjčka. Prosíme vraťte půjčené knihy co nejdříve do knihovny, '.
                'aby si je mohli půjčit ostatní, nebo zažádejte paní knihovnici o prodloužení')
        ->action('Zkontrolovat mé výpůjčky', route('user.current_borrows_reservations'))
        ->line('Kliknutím na tlačítko se dostanete k přehledu Vašich knihovních výpůjček.')
        ->line('Děkujeme');
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
            //
        ];
    }
}
