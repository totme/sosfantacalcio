<?php

namespace App\Notifications\Log;

use App\Enum\Role;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class CustomSlackNotification extends Notification
{
    use Queueable;

    /**
     * @var string
     */
    private $message;
    /**
     * @var string
     */
    private $class;
    /**
     * @var string
     */
    private $type;
    /**
     * @var array
     */
    private $fields;

    /**
     * Create a new notification instance.
     *
     * @param string $message
     * @param string $class
     * @param string $type
     * @param array $fields
     */
    public function __construct(string $message, string $class, string $type, array $fields = [])
    {
        $this->message = $message;
        $this->class = $class;
        $this->type = $type;
        $this->fields = $fields;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'slack'];
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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toSlack($notifiable)
    {
        $url = '';
        return
            (new SlackMessage)
                ->from(getenv('APP_NAME'), ($this->type == 'info') ? ':rainbow:' : ':ghost:')
                ->to('#sosfantacalcio')
                ->success()
                ->content($this->message)
                ->attachment(function ($attachment) use ($url) {
                    $attachment->title(strtoupper($this->type), $url)
                        ->fields($this->fields);
                });
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
