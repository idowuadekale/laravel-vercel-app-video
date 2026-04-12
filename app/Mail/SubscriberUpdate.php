<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscriberUpdate extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $subject;
    public $content;
    public $image_url;
    public $image;
    public $email; // ✅ Add this

    public function __construct($subject, $content, $image_url, $image, $email)
    {
        $this->subject = $subject;
        $this->content = $content;
        $this->image_url = $image_url;
        $this->image = $image;
        $this->email = $email; // ✅ Store email
    }

    public function build()
    {
        return $this->subject($this->subject)
                    ->view('mail.subscriber_update')
                    ->with([
                        'subject' => $this->subject,
                        'content' => $this->content,
                        'image_url' => $this->image_url,
                        'image' => $this->image,
                        'email' => $this->email, // ✅ Pass email to view
                    ]);
    }
}
