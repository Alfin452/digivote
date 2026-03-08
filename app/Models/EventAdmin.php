<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventAdmin extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'event_id',
        'role',
        'is_active',
        'last_login'
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_login' => 'datetime',
        'password' => 'hashed',
    ];

    // Admin mengelola satu event [cite: 273]
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}