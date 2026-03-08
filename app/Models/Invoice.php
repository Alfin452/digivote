<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    protected $fillable = [
        'xendit_id',
        'event_id',
        'team_id',
        'voter_name',
        'vote_qty',
        'amount',
        'status',
        'paid_at',
        'expired_at',
        'xendit_payload',
        'ip_address'
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'expired_at' => 'datetime',
        'xendit_payload' => 'array', // Otomatis parsing JSON ke Array
    ];

    // Invoice untuk satu tim di satu event [cite: 273]
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}