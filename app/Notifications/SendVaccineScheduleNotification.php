<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendVaccineScheduleNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $vaccine_user;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $user)
    {
        $this->vaccine_user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $name = $this->vaccine_user->name;
        $date = date_format(date_create($this->vaccine_user->scheduled_date),'d MD, Y');

        return (new MailMessage)
                    ->subject('Covid Vaccine Scheduled Mail')
                    ->view('notification.email',['name' => $name, 'date' => $date]);

    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
