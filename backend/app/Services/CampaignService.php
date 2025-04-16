<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\Lists;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class CampaignService
{
    public function createCampaign(array $data)
    {
        return Campaign::create([
            'title' => $data['title'],
            'subject' => $data['subject'],
            'content' => $data['content'],
            'list_id' => $data['list_id'],
            'status' => 'draft'
        ]);
    }

    public function sendCampaign(Campaign $campaign)
    {
        DB::transaction(function () use ($campaign) {
            // Get subscribers from the specific list
            $subscribers = NewsletterSubscriber::whereHas('lists', function($query) use ($campaign) {
                $query->where('lists.id', $campaign->list_id);
            })->get();

            foreach ($subscribers as $subscriber) {
                try {
                    Mail::raw($campaign->content, function ($message) use ($campaign, $subscriber) {
                        $message->to($subscriber->email)
                                ->subject($campaign->subject);
                    });
                } catch (\Exception $e) {
                    \Log::error('Campaign email send failed', [
                        'campaign_id' => $campaign->id,
                        'email' => $subscriber->email,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            $campaign->update([
                'status' => 'sent',
                'send_date' => now()
            ]);
        });
    }

    public function getAllCampaigns()
    {
        return Campaign::with('list')->get();
    }
}