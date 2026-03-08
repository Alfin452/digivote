<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    public $timestamps = false; // Karena di migrasi hanya ada created_at

    protected $fillable = [
        'event_id',
        'name',
        'sort_order',
        'created_at'
    ];

    // Kategori milik satu event [cite: 273]
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }
}
