<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskNotify extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data=$data;
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
                    ->subject('task  mail')
                    ->greeting('Welcome '.$this->data['name'])
                    ->line('details=> '.$this->data['description'])
                    ->line('user_id=> '.$this->data['user_id'])
                    ->line('category_id: '.$this->data['category_id'])
                    ->line('status: '.$this->data['status']);
                    // ->markdown([
                    //     'name'->$this->data['name'],
                    //     'description'->$this->data['description'],
                    //     'user_id'->$this->data['user_id'],
                    //     'category_id'->$this->data['category_id'],
                    //     'status'->$this->data['status'],
                    // ]);
                  
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
