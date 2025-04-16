<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Campaign extends Model
{
    protected $fillable = [
        'title', 
        'subject', 
        'content', 
        'list_id', 
        'send_date', 
        'status'
    ];

    public function list(): BelongsTo
    {
        return $this->belongsTo(Lists::class);
    }
}