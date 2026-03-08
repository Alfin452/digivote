<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlatformSetting extends Model
{
    public $timestamps = false; // Hanya ada updated_at di migrasi

    protected $fillable = [
        'key',
        'value',
        'updated_at'
    ];
}
