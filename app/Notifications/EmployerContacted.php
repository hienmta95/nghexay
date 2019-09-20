<?php


namespace App\Notifications;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Post;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class EmployerContacted extends Notification implements ShouldQueue
{
    use Queueable;
    
    protected $post;
    protected $message;
    
    public function __construct(Post $post, Message $message)
    {
        $this->post = $post;
        $this->message = $message;
    }
    
    public function via($notifiable)
    {
        if (!empty($this->post->email)) {
            if (config('settings.sms.message_activation') == 1) {
                if (!empty($this->post->phone) && $this->post->phone_hidden != 1) {
                    if (config('settings.sms.driver') == 'twilio') {
                        return ['mail', TwilioChannel::class];
                    }
                    
                    return ['mail', 'nexmo'];
                }
                
                return ['mail'];
            } else {
                return ['mail'];
            }
        } else {
            if (config('settings.sms.driver') == 'twilio') {
                return [TwilioChannel::class];
            }
            
            return ['nexmo'];
        }
    }
    
    public function toMail($notifiable)
    {
        return (new \App\Mail\EmployerContacted($this->post, $this->message));
    }
    
    public function toNexmo($notifiable)
    {
        return (new NexmoMessage())->content($this->smsMessage())->unicode();
    }
    
    public function toTwilio($notifiable)
    {
        return (new TwilioSmsMessage())->content($this->smsMessage());
    }
    
    protected function smsMessage()
    {
        return trans('sms.post_employer_contacted_content', [
            'appName'  => config('app.name'),
            'postId'   => $this->message->post_id,
            'message'  => str_limit(strip_tags($this->message->message), 50),
        ]);
    }
}
