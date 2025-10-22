<?php

namespace App\Notifications\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MagicLinkNotification extends Notification implements ShouldQueue
{
    use Queueable;

    // public string $url;
    /**
     * Create a new notification instance.
     */
    public function __construct(public string $url)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Magic Login Link ✨')
            ->greeting('Hello '.($notifiable->name ?? 'there').'!')
            ->line('Click the button below to log in securely. This link will expire in 10 minutes.')
            ->action('Login Now', $this->url)
            ->line('If you didn’t request this, please ignore this email.');
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'magic_link',
            'email' => $notifiable->email,
            // 'url' => $this->url,
            'sent_at' => now(),
        ];
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
