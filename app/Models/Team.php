<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    public $timestamps = false; // Karena di migrasi hanya ada created_at

    protected $fillable = [
        'event_id',
        'category_id',
        'number',
        'name',
        'location',
        'member_count',
        'image_path',
        'vote_count',
        'created_at'
    ];

    // Tim masuk satu event & satu kategori [cite: 273]
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
