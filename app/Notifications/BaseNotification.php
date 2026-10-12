<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Modules\Notifications\Channels\FirebaseChannel;

class BaseNotification extends Notification
{
    use Queueable;

    public string $message;

    public string $title;

    public $action_url;

    public array $channel;

    public bool $sendPush = true;

    public function __construct(string $message, string $title, array $channel, string|array|null $action_url = null)
    {
        $this->message = $message;
        $this->title = $title;
        $this->channel = $channel;
        $this->action_url = is_array($action_url) ? route(...$action_url)
            : (is_string($action_url) && ! str_starts_with($action_url, 'http') ? route($action_url) : $action_url);
    }

    public function via(object $notifiable): array
    {
        // Older callers may still request broadcast; Firebase replaces that transport.
        $channels = array_values(array_filter($this->channel, fn ($channel) => $channel !== 'broadcast'));
        if ($this->sendPush && (in_array('database', $channels, true) || in_array('broadcast', $this->channel, true))) {
            $channels[] = FirebaseChannel::class;
        }

        return array_values(array_unique($channels));
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)->line($this->message)
            ->action($this->title, $this->action_url ?? url('/'))
            ->line('Thank you for using our application!');
    }

    protected function getData(object $notifiable): array
    {
        return ['notification_id' => $this->id, 'message' => $this->message,
            'title' => $this->title, 'action_url' => $this->action_url ?? route('dashboard')];
    }

    public function toDatabase(object $notifiable): array
    {
        return $this->getData($notifiable);
    }

    public function toFirebase(object $notifiable): array
    {
        return $this->getData($notifiable);
    }

    public function toArray(object $notifiable): array
    {
        return $this->getData($notifiable);
    }
}
