<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\NewsletterSubscriber;

class Lists extends Model
{
    protected $fillable = [
        'name', 
        'description', 
        'user_id', 
        'is_default'
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(
            NewsletterSubscriber::class, 
            'subscriber_list', 
            'list_id', 
            'subscriber_id'
        );
    }

    public function campaigns(): HasMany
    {
        return $this->hasMany(Campaign::class, 'list_id');
    }

    // Scopes
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    // Utility methods
    public function getSubscriberCountAttribute()
    {
        return $this->subscribers()->count();
    }

    public function addSubscriber(NewsletterSubscriber $subscriber)
    {
        return $this->subscribers()->attach($subscriber);
    }

    public function removeSubscriber(NewsletterSubscriber $subscriber)
    {
        return $this->subscribers()->detach($subscriber);
    }
}