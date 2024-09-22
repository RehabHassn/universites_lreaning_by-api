<?php

namespace App\Notifications;

use App\Models\subscribtions;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscribtionNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    private $data;
    public function __construct($data)
    {
      $this->data=$data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['Database'];
    }
    public function toDatabase(object $notifiable){
        $subject = subscribtions::query()->with('user')->find($this->data['id']);
        $data =[
            'data'=>json_encode(['ar'=>'تم اضافه اشتراك جديد في ماده'.json_decode($subject->name,true)['ar'].
                'تبع دكتور'.$subject->user->username,
                'en'=>'New subscribtion added at subject name '.$subject->id,JSON_UNESCAPED_SLASHES,
            'sender_id'=>$subject->user->id,
        ];
        return $data;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
