<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'org',
        'description',
        'icon',
        'price_per_vote',
        'min_vote',
        'status',
        'started_at',
        'ended_at',
        'fee_percent'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    // Satu event dikelola satu admin event [cite: 273]
    public function admin(): HasOne
    {
        return $this->hasOne(EventAdmin::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
