<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\NewsletterSubscriber;

class Mail extends Model
{
    protected $fillable = [
        'campaign_id',
        'subscriber_id',
        'subject',
        'content',
        'status',
        'sent_at',
        'opened_at',
        'clicked_at'
    ];

    protected $dates = [
        'sent_at',
        'opened_at',
        'clicked_at'
    ];

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function subscriber(): BelongsTo
    {
        return $this->belongsTo(NewsletterSubscriber::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }
}