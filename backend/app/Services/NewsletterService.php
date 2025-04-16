<?php

namespace App\Services;

use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Mail;

class NewsletterService
{
    /**
     * Subscribe an email to the newsletter
     *
     * @param string $email
     * @return NewsletterSubscriber
     */
    public function subscribe(string $email): NewsletterSubscriber
    {
        return NewsletterSubscriber::create([
            'email' => $email,
            'subscribed_at' => now()
        ]);
    }

    /**
     * Unsubscribe an email from the newsletter
     *
     * @param string $email
     * @return void
     */
    public function unsubscribe(string $email): void
    {
        $subscriber = NewsletterSubscriber::where('email', $email)->first();
        
        if ($subscriber) {
            $subscriber->delete();
        }
    }

    /**
     * Send a newsletter campaign
     *
     * @param string $subject
     * @param string $content
     * @return array
     */
    public function sendCampaign(string $subject, string $content): array
    {
        $subscribers = NewsletterSubscriber::all();

        foreach ($subscribers as $subscriber) {
            Mail::raw($content, function ($message) use ($subject, $subscriber) {
                $message->to($subscriber->email)
                        ->subject($subject);
            });
        }

        return [
            'subject' => $subject,
            'recipients' => $subscribers->count()
        ];
    }
}