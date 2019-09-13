<?php

namespace App\Notifications;

use App\User;
use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailBase;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class VerifyEmail extends VerifyEmailBase implements ShouldQueue
{
    use Queueable;

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl);
        }

        $accessToken = User::find($notifiable->getKey())->getAccessToken();

        return (new MailMessage)
            ->from('laravel@rest.api')
            ->subject(Lang::get('Verify Email Address'))
            ->line(Lang::get('Please click the button below to verify your email address.'))
            ->action(Lang::get('Verify Email Address'), $verificationUrl)
            ->line(Lang::get('If you did not create an account, no further action is required.'))
            ->line(Lang::get('Yor Access Token is: '. $accessToken))
            ->line(Lang::get('Use: "headers" => ['))
            ->line(Lang::get('"Accept" => "application/json",'))
            ->line(Lang::get('"Authorization" => "Bearer '.$accessToken.'"'))
            ->line(Lang::get(']'))
            ->line(Lang::get('in your requests :)'))
            ->line(Lang::get('the restricted area is '.route('restrinct')));
    }

}
