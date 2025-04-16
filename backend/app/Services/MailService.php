<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\Mail as MailModel;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class MailService
{
    /**
     * Send campaign emails to subscribers
     *
     * @param Campaign $campaign
     * @return void
     */
    public function sendCampaignEmails(Campaign $campaign)
    {
        $subscribers = NewsletterSubscriber::whereHas('lists', function($query) use ($campaign) {
            $query->where('lists.id', $campaign->list_id);
        })->get();

        foreach ($subscribers as $subscriber) {
            $this->sendIndividualEmail($campaign, $subscriber);
        }
    }

    /**
     * Send individual email
     *
     * @param Campaign $campaign
     * @param NewsletterSubscriber $subscriber
     * @return void
     */
    private function sendIndividualEmail(Campaign $campaign, NewsletterSubscriber $subscriber)
    {
        // Create mail record
        $mailRecord = MailModel::create([
            'campaign_id' => $campaign->id,
            'subscriber_id' => $subscriber->id,
            'subject' => $campaign->subject,
            'content' => $campaign->content,
            'status' => 'pending'
        ]);

        try {
            // Send actual email
            Mail::raw($campaign->content, function ($message) use ($campaign, $subscriber) {
                $message->to($subscriber->email)
                        ->subject($campaign->subject);
            });

            // Update mail record
            $mailRecord->update([
                'status' => 'sent',
                'sent_at' => now()
            ]);
        } catch (\Exception $e) {
            // Log and update failed mail
            Log::error('Email sending failed', [
                'campaign_id' => $campaign->id,
                'subscriber_id' => $subscriber->id,
                'error' => $e->getMessage()
            ]);

            $mailRecord->update([
                'status' => 'failed'
            ]);
        }
    }

    /**
     * Send test email
     *
     * @param array $data
     * @param string $testEmail
     * @return bool
     */
    public function sendTestEmail(array $data, string $testEmail): bool
    {
        try {
            Mail::raw($data['content'], function ($message) use ($data, $testEmail) {
                $message->to($testEmail)
                        ->subject('Test: ' . $data['subject']);
            });

            return true;
        } catch (\Exception $e) {
            Log::error('Test email sending failed', [
                'email' => $testEmail,
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }
}