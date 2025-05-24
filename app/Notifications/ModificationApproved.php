<?php

namespace App\Notifications;

use App\Models\Modification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ModificationApproved extends Notification implements ShouldQueue
{
    use Queueable;

    public $modification;

    /**
     * Create a new notification instance.
     *
     * @param Modification $modification
     * @return void
     */
    public function __construct(Modification $modification)
    {
        $this->modification = $modification;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail']; // You can choose which channels to use
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
                    ->subject('Modification Approved')
                    ->line('Your modification has been approved.')
                    ->action('View Modification', url('/modifications/'.$this->modification->id))
                    ->line('Thank you for using our application!');
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
            'modification_id' => $this->modification->id,
            'message' => 'A modification you were interested in has been approved',
            'link' => '/modifications/'.$this->modification->id,
        ];
    }
}