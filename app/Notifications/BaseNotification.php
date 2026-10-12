<?php

namespace App\Notifications;

use App\Services\Notifications\FirebaseNotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BaseNotification extends Notification implements ShouldBroadcastNow
{
    use Queueable;

    public string $message;
    public string $title;
    public $action_url;
    public array $channel;

    public function __construct(string $message, string $title, array $channel, string|array|null $action_url = null)
    {
        $this->message = $message;
        $this->title = $title;
        $this->channel = $channel;

        if (is_array($action_url)) {
            $this->action_url = route(...$action_url);
        } elseif (is_string($action_url) && str_starts_with($action_url, 'http')) {
            $this->action_url = $action_url;
        } elseif (is_string($action_url)) {
            $this->action_url = route($action_url);
        } else {
            $this->action_url = null;
        }
    }

    public function via(object $notifiable): array
    {
        return $this->channel;
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line($this->message)
            ->action($this->title, $this->action_url ?? url('/'))
            ->line('Thank you for using our application!');
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'notification' => $this->getData($notifiable),
            'created_at' => now()->toDateTimeString(),
            'id' => $this->id,
            'type' => class_basename($this),
        ]);
    }

    protected function getData(object $notifiable): array
    {
        return [
            'message' => $this->message,
            'title' => $this->title,
            'action_url' => $this->action_url ?? route('dashboard'),
        ];
    }

    public function toDatabase(object $notifiable): array
    {
        $data = $this->getData($notifiable);

        if (method_exists($notifiable, 'deviceTokens')) {
            app(FirebaseNotificationService::class)->sendToUser($notifiable, $data);
        }

        return $data;
    }

    public function toArray(object $notifiable): array
    {
        return $this->getData($notifiable);
    }
}